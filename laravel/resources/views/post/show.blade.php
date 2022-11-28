@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="header">{{ __('Post') }}</div>
               <div class="cbody">
                <form method="post" action="{{ route('post.destroy',$post) }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
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
                    <button type="submit" class="btn btn-primary">{{ __('fields.delete') }}</button>
                    <a class="btn btn-primary" href="{{ route('post.edit',$post) }}" role="button">{{ __('fields.edit') }}</a>
                    <a class="btn btn-secondary" href="{{ route('post.index',$post) }}" role="button">{{ __('fields.back') }}</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
