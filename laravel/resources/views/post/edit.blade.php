@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Post') }}</div>
               <div class="card-body">
                    <form method="post" action="{{ route('post.update',$post) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <table class="table">
                            <thead>
                                <tr>
                                    <td scope="col">ID</td>
                                    <td scope="col">{{ __('fields.body') }}</td>
                                    <td scope="col">{{ __('fields.file') }}</td>
                                    <td scope="col">{{ __('fields.latitude') }}</td>
                                    <td scope="col">{{ __('fields.longitude') }}</td>
                                    <td scope="col">{{ __('fields.visibility_id') }}</td>
                                    <td scope="col">{{ __('fields.author') }}</td>
                                    <td scope="col">Created</td>
                                    <td scope="col">Updated</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->body }}</td>
                                    <td><img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" /></td>
                                    <td>{{ $post->latitude }}</td>
                                    <td>{{ $post->longitude }}</td>
                                    <td>{{ $post->visibility_id }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->created_at }}</td>
                                    <td>{{ $post->updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label for="body">{{ __('fields.body') }}</label><br>
                            <input type="text" id="body" name="body"><br>
                            <label for="latitude">{{ __('fields.latitude') }}</label><br>
                            <input type="text" id="latitude" name="latitude"><br>
                            <label for="longitude">{{ __('fields.longitude') }}</label><br>
                            <input type="text" id="longitude" name="longitude"><br>
                            <label for="visibility_id">{{ __('fields.visibility_id') }}</label><br>
                            <input type="text" id="visibility_id" name="visibility_id"><br>
                            <label for="upload">{{ __('fields.update') }}:</label>
                            <input type="file" class="form-control" name="upload"/>
                            <br>
                            <button type="submit" class="btn btn-primary">{{ __('fields.update') }}</button>
                            <a class="btn btn-secondary" href="{{ route('post.index') }}" role="button">{{ __('fields.back') }}</a>
                        </div> 
                    </form>
                     
                </div>
           </div>
       </div>
   </div>
</div>
@endsection