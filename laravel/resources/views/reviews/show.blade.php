@extends('layouts.app')
 
@section('content')
<div class="containerPlace2">
    <form method="post" action="{{ route('review.destroy',$review) }}" enctype="multipart/form-data">
        @csrf
        @method('DELETE')
        <div style="display:flex; justify-content: space-between">
            <div style="display:flex; justify-content:left; margin-top:0;">
                <img src="/img/fotocarnet.jpg" class="profImg"/>
                <h3 style="margin-top: 0.83em; text-transform: lowercase;">{{'@'.$review->user->name }}</h3>
            </div>
            <div style="display:flex; justify-content:right;">
                <a href="{{ url('/review') }}" style="text-decoration: none;"><i class="fa-solid fa-xmark fa-2x" style="color:#22252C;"></i></a>            
            </div>  
        </div>
        <div class="card__image" style="margin-top:0.5em; width:800px; height:300px; border:1px solid black;">
            <img src='{{ asset("storage/{$file->filepath}")}}' height="100%" width="100%"/>
        </div>
        <div class="car__info">
            <h3>{{$review->name }}</h3>
            <p>{{$review->description }}</p>
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
        </div>
        <br>
        <div>
            <button type="submit" class="btn btn-primary">Delete</button>
        </div>
    </form>
</div>
@endsection
