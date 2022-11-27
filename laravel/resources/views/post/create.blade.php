<!--
@if ($errors->any())
<div class="alert alert-danger">
   <ul>
       @foreach ($errors->all() as $error)
       <li>{{ $error }}</li>
       @endforeach
   </ul>
</div>
@endif
-->

@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Post') }}</div>
               <div class="card-body">
               <form id="create" method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
                    @csrf
                    @vite('resources/js/post/create.js')
                    
                    <div id="body">
                        <label for="body">{{ __('fields.body') }}</label><br>
                        <input type="text" id="body" name="body"><br>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>

                    <div class="form-group" id="upload">
                        <label for="upload">{{ __('fields.file') }}:</label>
                        <input type="file" class="form-control" id="upload" name="upload"/>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>

                    <div id="latitude">
                        <label for="latitude">{{ __('fields.latitude') }}</label><br>
                        <input type="text" id="latitude" name="latitude"><br>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>

                    <div id="longitude">
                        <label for="longitude">{{ __('fields.longitude') }}</label><br>
                        <input type="text" id="longitude" name="longitude"><br>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>

                    <div id="visibility_id">
                        <label for="visibility_id">{{ __('fields.visibility_id') }}</label><br>
                        <input type="text" id="visibility_id" name="visibility_id"><br><br>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('fields.create') }}</button>
                    <button type="reset" class="btn btn-secondary">{{ __('fields.reset') }}</button>
                    <a class="btn btn-secondary" href="{{ route('post.index') }}" role="button">{{ __('fields.back') }}</a>
                    </form>
                </div>
           </div>
       </div>
   </div>
</div>
@endsection
