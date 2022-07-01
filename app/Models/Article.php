<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Author;
use App\Models\User;
use App\Models\Comment;

class Article extends Model
{
    use HasFactory;

    protected $table='articles';


    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Author(){
        return $this->belongsTo(Author::class);
    }
}
