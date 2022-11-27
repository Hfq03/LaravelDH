@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Post') }}</div>
               <div class="card-body">
                <form method="post" action="{{ route('post.destroy',$post) }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
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
                               <td scope="col">{{ __('fields.created_at') }}</td>
                               <td scope="col">{{ __('fields.updated_at') }}</td>
                           </tr>
                       </thead>
                       <tbody>
                           <tr>
                               <td>{{ $post->id }}</a></td>
                               <td>{{ $post->body }}</td>
                               <!--<td>{{ $post->file_id }}</td>-->
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
                    <button type="submit" class="btn btn-primary">{{ __('fields.delete') }}</button>
                    <a class="btn btn-primary" href="{{ route('post.edit',$post) }}" role="button">{{ __('fields.edit') }}</a>
                    <a class="btn btn-secondary" href="{{ route('post.index',$post) }}" role="button">{{ __('fields.back') }}</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
