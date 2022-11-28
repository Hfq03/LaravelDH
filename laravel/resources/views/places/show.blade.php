@extends('layouts.app')
 
@section('content')
<div class="containerPlace2">
    <form method="post" action="{{ route('places.destroy',$place) }}" enctype="multipart/form-data">
        @csrf
        @method('DELETE')
        <div style="display:flex; justify-content:left; margin-top:0;">
            <img src="/img/fotocarnet.jpg" class="profImg"/>
            <h3 style="margin-top: 1.3em; text-transform: lowercase;">{{'@'.$place->user->name }}</h3>
            <div style="justify-content:right;">
                <i class="fa-regular fa-xmark"></i>            
            </div>
        </div>
        <div class="card__image" style="margin-top:0.5em; width:800px; height:300px; border:1px solid black;">
            <img src='{{ asset("storage/{$file->filepath}")}}' height="100%" width="100%"/>
        </div>
        <div class="car__info">
            <h3>{{$place->name }}</h3>
            <p>{{$place->description }}</p>
        </div>
        <div class="starsIcons">
            @if ($place->category_id == 1)
                <div>
                    <span class="fa fa-star checked"></span>
                </div>
            @elseif ($place->category_id == 2)
                <div>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                </div>
            @elseif ($place->category_id == 3)
                <div>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                </div>
            @elseif ($place->category_id == 4)
                <div>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                </div>
            @elseif ($place->category_id == 5)
                <div>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                </div>
            @endif
            <div>
                <i class="fa-regular fa-bookmark fa-lg"></i>
            </div>
        </div>
        <br>
        <div>
            <button type="submit" class="btn btn-primary">Delete</button>
            <a class="btn btn-primary" href="{{ route('places.edit',$place) }}" role="button">Edit</a>
        </div>
    </form>
</div>
@endsection
