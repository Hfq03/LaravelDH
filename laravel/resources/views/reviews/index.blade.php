@extends('layouts.app')
 
@section('content')
<div class="containerPlace">
    @foreach ($review as $rev)
        @foreach ($files as $file)
            @if($file->id == $rev->file_id)
                <a href="{{ route('review.show',$rev) }}"><div class="card">
                    <div style="display:flex; justify-content:left; align-items: center;">
                        <img src="/img/fotocarnet.jpg" class="profImg"/>
                        <h3 style="margin-top: 0.8em; text-transform: lowercase;">{{'@'.$rev->user->name }}</h3>
                    </div>
                    <div class="card__image">
                        <img src='{{ asset("storage/{$file->filepath}")}}' height="100%" width="100%" />
                    </div>
                    <div class="car__info">
                        <h3>{{$rev->title }}</h3>
                        <p>{{$rev->description }}</p>
                    </div>
                    <div class="starsIcons">
                        @if ($rev->stars == 1)
                            <div>
                                <span class="fa fa-star checked"></span>
                            </div>
                        @elseif ($rev->stars == 2)
                            <div>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </div>
                        @elseif ($rev->stars == 3)
                            <div>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </div>
                        @elseif ($rev->stars == 4)
                            <div>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                            </div>
                        @elseif ($rev->stars == 5)
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