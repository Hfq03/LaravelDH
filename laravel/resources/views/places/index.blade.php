@extends('layouts.app')
 
@section('content')
<div class="containerPlace">
    @foreach ($places as $place)
        @foreach ($files as $file)
            @if($file->id == $place->file_id)
                <a href="{{ route('places.show',$place) }}"><div class="card">
                    <div style="display:flex; justify-content:left; align-items: center;">
                        <img src="/img/fotocarnet.jpg" class="profImg"/>
                        <h3 style="margin-top: 0.8em; text-transform: lowercase;">{{'@'.$place->user->name }}</h3>
                    </div>
                    <div class="card__image">
                        <img src='{{ asset("storage/{$file->filepath}")}}' height="100%" width="100%" />
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
                </div></a>
            @endif
        @endforeach
    @endforeach    
</div>

@endsection
