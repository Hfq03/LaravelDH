<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'file_id',
        'stars',
        'visibility_id',
        'author_id',
    ];

    public function review(){
        return $this->belongsTo(Review::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'author_id');
    }
    public function author(){
       return $this->belongsTo(User::class);
    }
}
