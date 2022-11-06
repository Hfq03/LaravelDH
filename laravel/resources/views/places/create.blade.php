<!--
@if ($errors->any())
<div class="alert alert-danger">
   <ul>
       @foreach ($errors->all() as $error)
       <li>{{ $error }}</li>
       @endforeach
   </ul>
</div>
@endif
-->
<form method="post" action="{{ route('places.store') }}" enctype="multipart/form-data">
   @csrf
   <div class="form-group">
       <label for="upload"><font color="linear-gradient(90deg, rgba(2,0,36,1) 1%, rgba(41,21,46,1) 4%, rgba(130,68,68,1) 7%, rgba(33,176,208,1) 12%, rgba(0,212,255,0) 100%);">File:</font></label>
       <input type="file" class="form-control" name="upload"/>
       <br>
       <label for="name"><font color="linear-gradient(90deg, rgba(2,0,36,1) 1%, rgba(41,21,46,1) 4%, rgba(130,68,68,1) 7%, rgba(33,176,208,1) 12%, rgba(0,212,255,0) 100%);">Name:</font></label>
       <input type="text" class="form-control" name="name"/>
       <br>
       <label for="description"><font color="linear-gradient(90deg, rgba(2,0,36,1) 1%, rgba(41,21,46,1) 4%, rgba(130,68,68,1) 7%, rgba(33,176,208,1) 12%, rgba(0,212,255,0) 100%);">Description:</font></label>
       <input type="text" class="form-control" name="description"/>
       <br>
       <label for="latitude"><font color="linear-gradient(90deg, rgba(2,0,36,1) 1%, rgba(41,21,46,1) 4%, rgba(130,68,68,1) 7%, rgba(33,176,208,1) 12%, rgba(0,212,255,0) 100%);">Latitude:</font></label>
       <input type="text" class="form-control" name="latitude"/>
       <br>
       <label for="longitude"><font color="linear-gradient(90deg, rgba(2,0,36,1) 1%, rgba(41,21,46,1) 4%, rgba(130,68,68,1) 7%, rgba(33,176,208,1) 12%, rgba(0,212,255,0) 100%);">Longitude:</font></label>
       <input type="text" class="form-control" name="longitude"/>
       <br>
       <label for="category_id"><font color="linear-gradient(90deg, rgba(2,0,36,1) 1%, rgba(41,21,46,1) 4%, rgba(130,68,68,1) 7%, rgba(33,176,208,1) 12%, rgba(0,212,255,0) 100%);">Category_id:</font></label>
       <input type="text" class="form-control" name="category_id"/>
       <br>
       <label for="visibility_id"><font color="linear-gradient(90deg, rgba(2,0,36,1) 1%, rgba(41,21,46,1) 4%, rgba(130,68,68,1) 7%, rgba(33,176,208,1) 12%, rgba(0,212,255,0) 100%);">Visibility_id:</font></label>
       <input type="text" class="form-control" name="visibility_id"/>
       <br>
   </div>
   <button type="submit" class="btn btn-primary">Create</button>
   <button type="reset" class="btn btn-secondary">Reset</button>
</form>
<style type="text/css"> 
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    form {
        padding-top: 3em;
        font-family:'Roboto', sans-serif;
        margin: 0 auto; 
        width:250px;
    }
    form .form-field {
        margin:0;
        padding:5px 0 0 0;
    } 
    
    form label {
        font-size:15px;
        color:#757575;
        font-weight:normal;
        padding-top:5px;
        padding-bottom:5px;
        float:none;
        text-align:left;
        width:auto;
        display:block;
    }
    
    
 </style>