@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Places') }}</div>
               <div class="card-body">
                <form method="post" action="{{ route('places.destroy',$place) }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <table class="table">
                        <thead>
                            <tr>
                                <td scope="col">ID</td>
                                <td scope="col">Filepath</td>
                                <td scope="col">Name</td>
                                <td scope="col">Description</td>
                                <td scope="col">Author</td>
                                <td scope="col">Created</td>
                                <td scope="col">Updated</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $place->id }}</td>
                                <td><img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" /></td>
                                <td>{{ $place->name }}</td>
                                <td>{{ $place->description }}</td>
                                <td>{{ $place->user->name }}</td>
                                <td>{{ $place->created_at }}</td>
                                <td>{{ $place->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Delete</button>
                    <a class="btn btn-primary" href="{{ route('places.edit',$place) }}" role="button">Edit</a>
               </div>
           </div>
       </div>
   </div>
</div>

@endsection
