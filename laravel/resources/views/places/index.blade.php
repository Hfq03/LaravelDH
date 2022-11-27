@extends('layouts.app')
 
@section('content')
<div class="containerPlace">
    @foreach ($places as $place)
        @foreach ($files as $file)
            @if($file->id == $place->file_id)
                <a href="{{ route('places.show',$place) }}"><div class="card">
                    <img src="/img/fotocarnet.jpg" class="profImg"/>
                    <p>{{$place->user->name }}</p>
                    <div class="card__image">
                        <img src='{{ asset("storage/{$file->filepath}")}}' height="100%" width="100%" />
                    </div>
                    <div class="car__info--title">
                        <h3>{{$place->name }}</h3>
                        <p>{{$place->description }}</p>
                    </div>
                    <div>
                        @if ($place->category_id == 1)
                            <span class="fa fa-star checked"></span>
                        @elseif ($place->category_id == 2)
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                        @elseif ($place->category_id == 3)
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                        @elseif ($place->category_id == 4)
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                        @elseif ($place->category_id == 5)
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                        @endif
                    </div>
                </div></a>
            @endif
        @endforeach
    @endforeach    
</div>

@endsection
