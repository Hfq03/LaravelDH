<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'filepath',
        'filesize',
    ];
    public function places()
    {
        return $this->belongsTo(Places::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
