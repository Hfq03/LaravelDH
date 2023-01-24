<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\File;
use App\Models\Places;

class ReviewController extends Controller
{
    public function index(Places $place)
    {
        return response()->json([
            'success' => true,
            'data'    => Review::where('place_id', $place->id)->get(),
        ], 200);
    }

    public function store(Request $request)
    {
        //Validar fichero
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,mp4,png|max:1024',
            'title' => 'required',
            'description' => 'required',
            'stars' => 'required',
            'visibility_id' => 'required',
        ]);

        //Obtener datos
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $title = $request->get('title');
        $description = $request->get('description');
        $stars = $request->get('stars');
        $visibility_id = $request->get('visibility_id');
        \Log::debug("Storing review '{$fileName}' ($fileSize)...");

        //Subir archivo
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',
            $uploadName,
            'public'
        );

        if (\Storage::disk('public')->exists($filePath)){
            \Log::debug("Local storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");
        

            //Guardar datos en la BD
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);

            $review = Review::create([
                'title' => $title,
                'description' => $description,
                'file_id' => $file->id,
                'stars' => $stars,
                'visibility_id' => $visibility_id,
                'author_id' => auth()->user()->id,
            ]);

            \Log::debug("DB storage OK");

            return response()->json([
                'success' => true,
                'data'    => $review
            ], 201);

        } else {
            \Log::debug("Local storage FAILS");

            return response()->json([
                'success'  => false,
                'message' => 'Error storing review'
            ], 500);
        }

    }

    public function show($id)
    {
        $review =  Review::find($id);
        if($review == null){
            return response()->json([
                'success' => false,
                'message'    => 'Error review not found'
            ], 404);
        }
        else{
            return response()->json([
                'success'  => true,
                'data' => $review
            ], 200);
        }
    }

    public function destroy($id)
    {
        $review =  Review::find($id);
        if($review){
        
            if(auth()->user()->id == $review->author_id){

                $file=File::find($review->file_id);

                \Storage::disk('public')->delete($review -> id);
                $review->delete();

                \Storage::disk('public')->delete($file -> filepath);
                $file->delete();
                if (\Storage::disk('public')->exists($review->id)) {
                    \Log::debug("Local storage OK");
                    // Patró PRG amb missatge d'error
                    return response()->json([
                        'success'  => false,
                        'message' => 'Error deleting review'
                    ], 500);
                }
                else{
                    \Log::debug(" Review Delete");
                    // Patró PRG amb missatge d'èxit
                    return response()->json([
                        'success' => true,
                        'data'    => $review
                    ], 200);
                } 
                
            }
            else{
                return response()->json([
                    'success'  => false,
                    'message' => 'Error deleting review, its not yours'
                ], 500);
            }
        }
        else{
            return response()->json([
                'success'  => false,
                'message' => ' Review not found'
            ], 404);

        } 
    }
}
