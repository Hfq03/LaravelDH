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
                               <td scope="col">Body</td>
                               <td scope="col">File</td>
                               <td scope="col">Latitude</td>
                               <td scope="col">Longitude</td>
                               <td scope="col">Visibility</td>
                               <td scope="col">Author</td>
                               <td scope="col">Created</td>
                               <td scope="col">Updated</td>
                           </tr>
                       </thead>
                       <tbody>
                           <tr>
                               <td>{{ $post->id }}</a></td>
                               <td>{{ $post->body }}</td>
                               <!--<td>{{ $post->file_id }}</td>-->
                               <td><img class="img-fluid" src="{{ asset("storage/{$post->filepath}") }}" /></td>
                               <td>{{ $post->latitude }}</td>
                               <td>{{ $post->longitude }}</td>
                               <td>{{ $post->visibility_id }}</td>
                               <td>{{ $author->name }}</td>
                               <td>{{ $post->created_at }}</td>
                               <td>{{ $post->updated_at }}</td>
                           </tr>
                       </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Delete</button>
                    <a class="btn btn-primary" href="{{ route('post.edit',$post) }}" role="button">Edit</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
