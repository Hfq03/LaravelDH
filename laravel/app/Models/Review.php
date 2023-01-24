<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'place_id',
        'review',
        'stars',
    ];

    public function user(){
        return User::find($this->user_id);
    }
}
