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
        // return response()->json([
        //     'success' => true,
        //     'data'    => Review::all()->where('place_id', $place->id),
        // ], 200);
        $review =  Review::all()->where('place_id', $place->id);
        return response()->json([
            'success' => true,
            'data' => $review,
        ], 200);
    }

    public function store(Request $request, $id)
    {
        $place =  Places::find($id);

        //Validar fichero
        $validatedData = $request->validate([
            'review' => 'required|string',
            'stars' => 'required|integer',
        ]);

        $review = Review::create([
            'user_id' => auth()->user()->id,
            'place_id' => $place->id,
            'review' => $request->input('review'),
            'stars' => $request->input('stars')
        ]);

        \Log::debug("DB storage OK");

        return response()->json([
            'success' => true,
            'data'    => $review
        ], 201);

        

    }

    public function destroy($id, $idR)
    {
        $place =  Places::find($id);
        $review =  Review::find($idR);
        if($review){
            if(auth()->user()->id == $review->user_id){
                $review->delete();
                
                return response()->json([
                    'success' => true,
                    'data'    => $review
                ], 200); 
            
            } else{
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