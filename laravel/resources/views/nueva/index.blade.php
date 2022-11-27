@extends('layouts.app')
@section('content')
<h2 class="title" style="text-align: center; margin-top: 3em;">¿Qué quieres crear?</h2>
<div class="containerPlace">
  <a href="{{ route('post.create') }}"><div class="card">
    <img src="/img/post.jpg" height="100%" width="100%"/>
    <div class="card__info">
      <h2>Post</h2>
      <p>Cuentanos qué está pasando.</p>
    </div>
  </div></a> 
  <a href="{{ route('places.create') }}"><div class="card">
    <img src="/img/places.jpg" height="100%" width="100%"/>
    <div class="card__info">
      <h2>Place</h2>
      <p>Escribe una reseña de un sitio.</p>
    </div>
  </div></a>
</div>
@endsection