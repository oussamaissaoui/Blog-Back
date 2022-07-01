<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Article;

class Author extends Model
{
    use HasFactory;

    protected $table='Authors';

    public function article(){
        return $this->hasMany(Article::class);
    }
}
