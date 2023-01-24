@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Review') }}</div>
               <div class="card-body">
                    <form id="create" method="post" action="{{ route('reviews.store',$place) }}" enctype="multipart/form-data">
                        @csrf
                        <div id="review">
                            <label for="review">{{ __('fields.review') }}</label><br>
                            <input type="text" id="review" name="review"><br>
                            <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                        </div>
                        <div id="stars">
                            <label for="stars">{{ __('fields.stars') }}</label><br>
                            <input type="text" id="stars" name="stars"><br>
                            <p class="error alert alert-danger alert-dismissible fade show errorHidden"></p>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
           </div>
       </div>
   </div>
</div>
@endsection