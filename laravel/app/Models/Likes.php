<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable = [
        'name',
        'file_id',
        'author_id',
    ];

    public function places(){
        return $this->belongsTo(Places::class);
    }
    public function user(){
        return $this->belongsTo(User::class, 'author_id');
    }
    public function author(){
       return $this->belongsTo(User::class);
    }

}