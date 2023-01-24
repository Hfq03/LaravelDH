@extends('layouts.app')
 
@section('content')
<div class="containerPlace">
    @foreach ($reviews as $review)
        <div class="card">
            <div style="display:flex; justify-content:left; align-items: center;">
                <img src="/img/fotocarnet.jpg" class="profImg"/>
                <h3 style="margin-top: 0.8em; text-transform: lowercase;">{{'@'.$review->user()->name }}</h3>
            </div>
            <div class="car__info">
                <p style="color:black; font-size:1.3em;">{{$review->review }}</p>
            </div>
            <div class="starsIcons">
                @if ($review->stars == 1)
                    <div>
                        <span class="fa fa-star checked"></span>
                    </div>
                @elseif ($review->stars == 2)
                    <div>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                    </div>
                @elseif ($review->stars == 3)
                    <div>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                    </div>
                @elseif ($review->stars == 4)
                    <div>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                    </div>
                @elseif ($review->stars == 5)
                    <div>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                    </div>
                @endif
                <div>
                    <form method="post" action="{{ route('reviews.delete',[$place, $review]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach    
</div>

@endsection