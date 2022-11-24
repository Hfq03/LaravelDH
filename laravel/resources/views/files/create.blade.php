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
<!-- <form id="create" method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
   @csrf
   @vite('resources/js/files/create.js')
   <div class="form-group">
       <label for="upload">File:</label>
       <input type="file" class="form-control" name="upload"/>
   </div>
   <p id="mError"></p>
   <button type="submit" class="btn btn-primary">Create</button>
   <button type="reset" class="btn btn-secondary">Reset</button>
</form> -->

@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
                <div class="card-header">{{ __('File') }}</div>
                <div class="card-body">
                <form id="create" method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
                    @csrf
                    @vite('resources/js/files/create.js')
                    <div class="form-group">
                        <input type="file" class="form-control" name="upload"/>
                    </div>
                    <p id="mError"></p>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
           </div>
       </div>
   </div>
</div>
@endsection