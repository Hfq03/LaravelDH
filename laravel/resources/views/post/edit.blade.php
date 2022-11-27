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
                            <div>
                                <td>
                                    <p>{{ __('fields.created_at') }}: {{ $post->created_at }}</p> 
                                </td>
                                <td>
                                    <p class="derecha">{{ __('fields.updated_at') }}: {{ $post->updated_at }}</p>
                                </td>
                            <div>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">{{ $post->user->name }}</td>
                                </tr>
                                <tr>
                                    @if($file->id == $post->file_id)
                                        <td colspan="2"><img class="img" src="{{ asset("storage/{$file->filepath}") }}" /></td>
                                    @endif
                                </tr>
                            </tbody>
                            <tr>
                                <td colspan="2">{{ $post->user->name }}:&nbsp{{ $post->body }}</td>
                            </tr>
                        </table>
                        <div class="form-group">
                            <div class="eizquierda">
                                <label for="body">{{ __('fields.body') }}</label>
                                <input type="text" id="body" name="body">
                                <label for="latitude">{{ __('fields.latitude') }}</label>
                                <input type="text" id="latitude" name="latitude">
                            </div>
                            <br>
                            <div class="ederecha">
                                <label for="longitude">{{ __('fields.longitude') }}</label>
                                <input type="text" id="longitude" name="longitude">
                                <label for="visibility_id">{{ __('fields.visibility_id') }}</label>
                                <input type="text" id="visibility_id" name="visibility_id">
                            </div>
                            <br>
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