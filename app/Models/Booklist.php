<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booklist extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'publication_year', 'price', 'description', 'cover_image', 'category_id'];

    public function relatedBooks()
    {
        return self::where('genre',$this->genre)->where('id','!=',$this->id)->take(4)->get();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
