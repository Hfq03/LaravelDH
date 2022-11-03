@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Files') }}</div>
               <div class="card-body">
                <form method="post" action="{{ route('files.destroy',$file) }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <table class="table">
                        <thead>
                            <tr>
                                <td scope="col">ID</td>
                                <td scope="col">Filepath</td>
                                <td scope="col">Filesize</td>
                                <td scope="col">Created</td>
                                <td scope="col">Updated</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $file->id }}</td>
                                <td><img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" /></td>
                                <td>{{ $file->filesize }}</td>
                                <td>{{ $file->created_at }}</td>
                                <td>{{ $file->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Delete</button>
                    <a class="btn btn-primary" href="{{ route('files.edit',$file) }}" role="button">Edit</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
