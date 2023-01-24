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
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Places $place)
    {
        return view("reviews.index", [
            "reviews" => Review::all()->where('place_id', $place->id),
            "place" => $place,
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Places $place)
    {
        return view("reviews.create", [
            "place" => $place,
        ]); 

    }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Places $place)
    {
        //Validar fichero
        $validatedData = $request->validate([
            'review' => 'required',
            'stars' => 'required',
        ]);
        $review = $request->get('review');
        $stars = $request->get('stars');
        $user = auth()->user()->id;
        \Log::debug("Placeid '{$place->id}' rev ($review) st $stars id $user...");
        $review = Review::create ([
            'user_id'   => $user,
            'place_id'  => $place->id,
            'review'    => $review,
            'stars'     => $stars,
        ]);
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
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
    public function destroy(Places $place, Review $review)
    {
        $review->delete();
        return redirect()->back();
    }

}
