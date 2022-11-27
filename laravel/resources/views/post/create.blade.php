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
                    <label for="body">{{ __('fields.body') }}</label><br>
                    <input type="text" id="body" name="body"><br>
                    <div class="form-group">
                        <label for="upload">{{ __('fields.upload') }}</label>
                        <input type="file" class="form-control" name="upload"/>
                    </div>
                    <p id="pError" class="alert alert-danger alert-dismissible fade show errorHidden"></p>
                    <label for="latitude">{{ __('fields.latitude') }}</label><br>
                    <input type="text" id="latitude" name="latitude"><br>
                    <label for="longitude">{{ __('fields.longitude') }}</label><br>
                    <input type="text" id="longitude" name="longitude"><br>
                    <label for="visibility_id">{{ __('fields.visibility_id') }}</label><br>
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
