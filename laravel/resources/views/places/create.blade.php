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
               <div class="card-header">{{ __('Places') }}</div>
               <div class="card-body">
               <form id="create" method="post" action="{{ route('places.store') }}" enctype="multipart/form-data">
                    @csrf
                    @vite('resources/js/places/create.js')
                    <div id="name">
                        <label for="name">Name</label><br>
                        <input type="text" id="name" name="name"><br>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>
                    <div class="form-group" id="upload">
                        <label for="upload">Place:</label>
                        <input type="file" id="upload" class="form-control" name="upload"/>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>

                    <div id="description">
                        <label for="description">Description</label><br>
                        <input type="text" id="description" name="description"><br>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>
                    
                    <div id="latitude">
                        <label for="latitude">Latitude</label><br>
                        <input type="text" id="latitude" name="latitude"><br>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>

                    <div id="longitude">
                        <label for="longitude">Longitude</label><br>
                        <input type="text" id="longitude" name="longitude"><br>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>

                    <div id="category_id">
                        <label for="category_id">Category</label><br>
                        <input type="text" id="category_id" name="category_id"><br><br>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>
                    
                    <div id="visibility_id">
                        <label for="visibility_id">Visibility</label><br>
                        <input type="text" id="visibility_id" name="visibility_id"><br><br>
                        <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
           </div>
       </div>
   </div>
</div>
@endsection