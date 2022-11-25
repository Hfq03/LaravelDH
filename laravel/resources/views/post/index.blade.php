@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Post') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                           <tr>
                               <td scope="col">ID</td>
                               <td scope="col">{{ __('fields.body') }}</td>
                               <td scope="col">{{ __('fields.file_id') }}</td>
                               <td scope="col">{{ __('fields.latitude') }}</td>
                               <td scope="col">{{ __('fields.longitude') }}</td>
                               <td scope="col">{{ __('fields.visibility_id') }}</td>
                               <td scope="col">{{ __('fields.author_id') }}</td>
                               <td scope="col">{{ __('fields.created_at') }}</td>
                               <td scope="col">{{ __('fields.updated_at') }}</td>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($post as $p)
                           <tr>
                               <td><a href="{{ route('post.show',$p) }}">{{ $p->id }}</a></td>
                               <td>{{ $p->body }}</td>
                               <td>{{ $p->file_id }}</td>
                               <td>{{ $p->latitude }}</td>
                               <td>{{ $p->longitude }}</td>
                               <td>{{ $p->visibility_id }}</td>
                               <td>{{ $p->author_id }}</td>
                               <td>{{ $p->created_at }}</td>
                               <td>{{ $p->updated_at }}</td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
                   <a class="btn btn-primary" href="{{ route('post.create') }}" role="button">Add new file</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
