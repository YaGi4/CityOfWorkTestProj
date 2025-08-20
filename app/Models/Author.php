<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'second_name', 'patronymic'];

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id', 'id');
    }
}
