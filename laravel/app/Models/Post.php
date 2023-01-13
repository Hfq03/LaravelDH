<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable = [
        'body',
        'file_id',
        'latitude',
        'longitude',
        'visibility_id',
        'author_id',
    ];
    public function file(){
        return $this->belongsTo(File::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'author_id');
    }
    public function author(){
        return $this->belongsTo(User::class);
    }
    public function liked()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function comprobarlike(){
        $post_id= $this->id;
        $user_id = auth()->user()->id;
        $select = "SELECT id FROM likes WHERE post_id = $post_id and user_id = $user_id";
        $like_id = DB::select($select);
        return empty($like_id);
    }

    public function contadorlike(){
        return DB::table('likes')->where (['post_id' => $this->id])->count();
    }


}
