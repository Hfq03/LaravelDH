@extends('layouts.app')
 
@section('content')
@foreach ($post as $p)
    <div class="cont">
        <div class="card">
            <div class="header"><i class="fa-regular fa-circle-user">&nbsp</i>{{ $p->user->name }}</div>
                <div class="cbody">
                    <table class="table">
                        <thead>
                            <div>
                                <td>
                                    <p>{{ __('fields.created_at') }}: {{ $p->created_at }}</p> 
                                </td>
                                <td>
                                    <p class="derecha">{{ __('fields.updated_at') }}: {{ $p->updated_at }}</p>
                                </td>
                            <div>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($files as $file)
                                    @if($file->id == $p->file_id)
                                        <td colspan="2"><img class="img" src="{{ asset("storage/{$file->filepath}") }}" /></td>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <form method="post" action="{{ route('post.index') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('likes')
                                        <i class="fa-regular fa-heart fa-2x"></i>
                                        &nbsp
                                        <i class="fa-regular fa-comment fa-2x"></i>
                                        @if(auth()->user()->id == $p->author_id)
                                            <a class="text" href="{{ route('post.show',$p) }}"><i class="fa-solid fa-gear fa-2x"></i></i></a>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                        <tr>
                            <td colspan="2">{{ $p->user->name }}:&nbsp{{ $p->body }}</td>
                        </tr> 
                    </table>
                </div>
            </div>
            <br>
        </div>
    </div>
@endforeach
<div class="cont">
    <a class="btn btn-primary" href="{{ route('post.create') }}" role="button">{{ __('fields.añadir_archivo') }}</a>
</div>
@endsection
