<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Likes;
use App\Models\File;
use App\Models\User;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => Post::all(),
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
        'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024',
        'body' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'visibility_id' => 'required',
        ]);
    
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $body = $request->get('body');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $visibility_id = $request->get('visibility_id');
        $author_id = $request->get('author_id');
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

            $post = Post::create([  
                'body' => $body,
                'file_id' => $file->id,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'visibility_id' => $visibility_id,
                'author_id' => auth()->user()->id,
            ]);

            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $post
            ], 201);
        } else {
            \Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return response()->json([
                'success'  => false,
                'message' => 'Error creating file'
            ], 421);
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

        $post = Post::find($id);
        if($post){
            if($id){
                return response()->json([
                    'success' => true,
                    'data'    => $post,
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message'    => "Post doesen't exist",
                ], 500);
            }
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error'
            ], 404);
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
        // Validar fitxer
        $post = Post::find($id);
        if($post){

            $file=File::find($post->file_id);

            $validatedData = $request->validate([
                'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
            ]);
        
            // Obtenir dades del fitxer
            $upload = $request->file('upload');
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
            
            if (\Storage::disk('public')->exists($filePath)) {
                \Log::debug("Local storage OK");
                $fullPath = \Storage::disk('public')->path($filePath);
                \Log::debug("File saved at {$fullPath}");
                // Desar dades a BD
                
                $file->filepath=$filePath;
                $file->filesize=$fileSize;
                $file->save();
                \Log::debug("DB storage OK");   
                $post->body=$request->input('body');
                $post->latitude=$request->input('latitude');
                $post->longitude=$request->input('longitude');
                $post->visibility_id=$request->input('visibility_id');
                $post->save();
                // Patró PRG amb missatge d'èxit
                return response()->json([
                    'success' => true,
                    'data'    => $post
                ], 200);
            } else {
                \Log::debug("Local storage FAILS");
                // Patró PRG amb missatge d'error
                return response()->json([
                    'success'  => false,
                    'message' => 'Error updating file'
                ], 421);
            }
        }else{
            return response()->json([
                'success'  => false,
                'message' => 'Error'
            ], 404);
        }
    }

    public function likes(Post $post){
        $likes = Likes::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
        ]);
        if ($likes) {
            return response()->json([
                'success' => true,
                'data' => $likes
            ], 200);
        } else {
            return response()->json([
                'succes' => false,
                'message' => 'Error deleting file'
            ], 500);
        }
    }
    public function unlikes(Post $post)
    {
        $likes=DB::table('likes')->where('user_id', auth()->user()->id, )
            ->where('post_id', $post->id)->delete();
        if ($likes) {
            return response()->json([
                'success' => true,
                'data' => $likes
            ], 200);
        } else {
            return response()->json([
                'succes' => false,
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
        $post = Post::find($id);
        Log::debug("Post id: {$id}");
        Log::debug($post);
        if($post){
            $post->delete();
            return response()->json([
                'success' => true,
                'data'    => $post
            ], 200);
        }else {
            return response()->json([
                'success'  => false,
                'message' => 'Error'
            ], 404);
        }
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }

}