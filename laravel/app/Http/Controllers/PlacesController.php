<?php

namespace App\Http\Controllers;

use App\Models\Places;
use App\Models\User;
use App\Models\Favourite;
use App\Models\File;
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
        return view("places.index", [
            "places" => Places::all(),
            "files" => File::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("places.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validar fichero
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,mp4,png|max:1024',
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'category_id' => 'required',
            'visibility_id' => 'required',
        ]);

        //Obtener datos
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

            $place = Places::create([
                'name' => $name,
                'description' => $description,
                'file_id' => $file->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'category_id' => $category_id,
                'visibility_id' => $visibility_id,
                'author_id' => auth()->user()->id,
            ]);

            \Log::debug("DB storage OK");

            return redirect()->route('places.show', $place)
                ->with('success', __('File successfully saved'));

        } else {
            \Log::debug("Local storage FAILS");

            return redirect()->route("files.create")
                ->with('error', __('ERROR uploading file'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function show(Places $place)
    {
        $file = File::find($place->file_id);
        $user = User::find($place->author_id);
        $visibility=Visibility::find($place->visibility_id);
        $contFav=Favourite::where('place_id','=',$place->id)->count();

        $control = false;
        try{
            if (Favourite::where('user_id', '=', auth()->user()->id)->where('place_id','=',$place->id)->exists()){
                $control = true;
            }
        } catch (Exception $e){
            $control = false;
        }

        return view("places.show", [
            'place' => $place,
            'file' => $file,
            'author' => $place->user,
            'visibility' => $visibility,
            'control' => $control,
            'favourites' => $contFav,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function edit(Places $place)
    {
        $file = File::find($place->file_id);
        return view("places.edit", [
            'place' => $place,
            'file' => $file,
            'autor' => $place->user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Places $place)
    {
        // Validar fichero
        $validatedData = $request->validate([
            'upload' => 'mimes:gif,jpeg,jpg,mp4,png|max:1024',
        ]);
    
        $file=File::find($place->file_id);

        $upload = $request->file('upload');
        $controlNull = FALSE;
        if(! is_null($upload)){
            $fileName = $upload->getClientOriginalName();
            $fileSize = $upload->getSize();

            \Log::debug("Storing file '{$fileName}' ($fileSize)...");

            // Subir fichero
            $uploadName = time() . '_' . $fileName;
            $filePath = $upload->storeAs(
                'uploads',    
                $uploadName ,   
                'public'       
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

            // Guardar datos en la BD
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

            return redirect()->route('places.show', $place)
                ->with('success', __('Place Successfully Saved'));

        } else {
            \Log::debug("Local storage FAILS");

            return redirect()->route("places.edit")
                ->with('error', __('ERROR Uploading Place'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function destroy(Places $place)
    {
        $file=File::find($place->file_id);

        \Storage::disk('public')->delete($place -> id);
        $place->delete();

        \Storage::disk('public')->delete($file -> filepath);
        $file->delete();
        if (\Storage::disk('public')->exists($place->id)) {
            \Log::debug("Local storage OK");

            return redirect()->route('places.show', $place)
                ->with('error', __('Error place already exist'));
        }
        else{
            \Log::debug("Place Delete");

            return redirect()->route("places.index")
                ->with('success', __('Place Successfully Deleted'));
        }
    }

    public function favourite(Places $place){

        $favourite = Favourite::create([
            'user_id' => auth()->user()->id,
            'place_id' => $place->id,
        ]);

        return redirect()->back();

    }

    public function unfavourite(Places $place){

        Favourite::where('user_id',auth()->user()->id)->where('place_id',$place->id)->delete();
        
        return redirect()->back();

    }

}
