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
               <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
                    @csrf
                    <label for="body">Body</label><br>
                    <input type="text" id="body" name="body"><br>
                    <div class="form-group">
                        <label for="upload">File:</label>
                        <input type="file" class="form-control" name="upload"/>
                    </div>
                    <label for="latitude">Latitude</label><br>
                    <input type="text" id="latitude" name="latitude"><br>
                    <label for="longitude">Longitude</label><br>
                    <input type="text" id="longitude" name="longitude"><br>
                    <label for="visibility_id">Visibility</label><br>
                    <input type="text" id="visibility_id" name="visibility_id"><br><br>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
           </div>
       </div>
   </div>
</div>
@endsection
