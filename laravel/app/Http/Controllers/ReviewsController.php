<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Places;
use App\Models\User;
use App\Models\Favourite;
use App\Models\File;
use App\Models\Visibility;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("review.index", [
            "review" => Review::all(),
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
        return view("review.create");
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

            return redirect()->route('review.show', $review)
                ->with('success', __('Review successfully saved'));

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
    public function show(Review $review)
    {
        $file = File::find($review->file_id);
        $user = User::find($review->author_id);
        $visibility=Visibility::find($review->visibility_id);

        $control = false;
        try{
            if (Favourite::where('user_id', '=', auth()->user()->id)->where('place_id','=',$place->id)->exists()){
                $control = true;
            }
        } catch (Exception $e){
            $control = false;
        }

        return view("review.show", [
            'review' => $review,
            'file' => $file,
            'author' => $review->user,
            'visibility' => $visibility,
            'control' => $control
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $Review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $file=File::find($review->file_id);

        \Storage::disk('public')->delete($review -> id);
        $review->delete();

        \Storage::disk('public')->delete($file -> filepath);
        $file->delete();
        if (\Storage::disk('public')->exists($review->id)) {
            \Log::debug("Local storage OK");

            return redirect()->route('review.show', $review)
                ->with('error', __('Error review already exist'));
        }
        else{
            \Log::debug("Review Delete");

            return redirect()->route("review.index")
                ->with('success', __('Review Successfully Deleted'));
        }
    }

}
