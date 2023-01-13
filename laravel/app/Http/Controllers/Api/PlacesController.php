<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Favorite;
use Illuminate\Support\Facades\Auth;
use App\Models\Places;
use App\Models\Favourite;
use App\Models\File;
use App\Models\User;
use App\Models\Visibility;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;


class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places =  Places::all();
        return response()->json([
            'success' => true,
            'data' => $places,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar fitxer
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,mp4,png|max:1024',
            'name' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'category_id' => 'required',
            'visibility_id' => 'required',
        ]);
    
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $name = $request->get('name');
        $description = $request->get('description');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $category_id = $request->get('category_id');
        $visibility_id = $request->get('visibility_id');
        \Log::debug("Storing file '{$fileName}' ($fileSize)...");

        // Pujar fitxer al disc dur
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );
    
        if (\Storage::disk('public')->exists($filePath)) {
            \Log::debug("Local storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");

            // Desar dades a BD

            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);

            $place =  Places::create([
                'name' => $name,
                'description' => $description,
                'file_id' => $file->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'category_id' => $category_id,
                'visibility_id' => $visibility_id,
                'author_id' =>auth()->user()->id,
            ]);

            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 201);


        } else {
            \Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return response()->json([
                'success'  => false,
                'message' => 'Error storing place'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place =  Places::find($id);
        if($place == null){
            return response()->json([
                'success' => false,
                'message'    => 'Error place not found'
            ], 404);
        }
        else{
            return response()->json([
                'success'  => true,
                'data' => $place
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $place =  Places::find($id);
        if ($place){   
        
            // Validar fitxer
            $validatedData = $request->validate([
                'upload' => 'mimes:gif,jpeg,jpg,mp4,png|max:1024',
            ]);
        
            $file=File::find($place->file_id);

            // Obtenir dades del fitxer

            $upload = $request->file('upload');
            $controlNull = FALSE;

            if(! is_null($upload)){
                $fileName = $upload->getClientOriginalName();
                $fileSize = $upload->getSize();

                \Log::debug("Storing file '{$fileName}' ($fileSize)...");

                // Pujar fitxer al disc dur
                $uploadName = time() . '_' . $fileName;
                $filePath = $upload->storeAs(
                    'uploads',      // Path
                    $uploadName ,   // Filename
                    'public'        // Disk
                );
            }

            else{
                $filePath = $file->filepath;
                $fileSize = $file->filesize;
                $controlNull = TRUE;
            }

            if (\Storage::disk('public')->exists($filePath)) {
                if ($controlNull == FALSE){
                    \Storage::disk('public')->delete($file->filepath);
                    \Log::debug("Local storage OK");
                    $fullPath = \Storage::disk('public')->path($filePath);
                    \Log::debug("File saved at {$fullPath}");

                }

                // Desar dades a BD

                $file->filepath=$filePath;
                $file->filesize=$fileSize;
                $file->save();
                \Log::debug("DB storage OK");
                $place->name=$request->input('name');
                $place->description=$request->input('description');
                $place->latitude=$request->input('latitude');
                $place->longitude=$request->input('longitude');
                $place->category_id=$request->input('category_id');
                $place->visibility_id=$request->input('visibility_id');
                $place->save();

                // Patró PRG amb missatge d'èxit
                return response()->json([
                    'success' => true,
                    'data'    => $place
                ], 201);

            } else {
                \Log::debug("Local storage FAILS");
                // Patró PRG amb missatge d'error
                return response()->json([
                    'success'  => false,
                    'message' => 'Error uploading place'
                ], 500);
            }
        }
        else{
            return response()->json([
                'success'  => false,
                'message' => 'Error searching place'
            ], 404);
        }
    }


    public function favorite(Places $place){
        $favorite=Favourite::create([
            'user_id'=>auth()->user()->id,
            'place_id'=>$place->id,
        ]);
        if ($favorite){
            return response()->json([
                'success' => true,
                'data'    => $favorite
            ], 200);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error deleting file'
            ], 500);
        }        
    }


    public function unfavorite(Places $place)
    {
        $favorite=DB::table('favourites')->where(['user_id'=>Auth::id(),'place_id'=>$place->id])->delete();
        if ($favorite){
            return response()->json([
                'success' => true,
                'data'    => $favorite
            ], 200);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error deleting file'
            ], 500);
        }     
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place =  Places::find($id);
        if($place){
        
            if(auth()->user()->id == $place->author_id){

                $file=File::find($place->file_id);

                \Storage::disk('public')->delete($place -> id);
                $place->delete();

                \Storage::disk('public')->delete($file -> filepath);
                $file->delete();
                if (\Storage::disk('public')->exists($place->id)) {
                    \Log::debug("Local storage OK");
                    // Patró PRG amb missatge d'error
                    return response()->json([
                        'success'  => false,
                        'message' => 'Error deleting place'
                    ], 500);
                }
                else{
                    \Log::debug(" Places Delete");
                    // Patró PRG amb missatge d'èxit
                    return response()->json([
                        'success' => true,
                        'data'    => $place
                    ], 200);
                } 
                
            }
            else{
                return response()->json([
                    'success'  => false,
                    'message' => 'Error deleting place, its not yours'
                ], 500);
            }
        }
        else{
            return response()->json([
                'success'  => false,
                'message' => ' Places not found'
            ], 404);

        } 

    }

}
