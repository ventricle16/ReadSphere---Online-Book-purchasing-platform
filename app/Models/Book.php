<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
   use HasFactory;

   protected $fillable = [
       'title',
       'author',
       'cover_url',
       'price',
       'genre',
       'description',
       'seo_tags',
       'file_path',
       'file_type',
       'file_size',
       'preview_file_path',
       'preview_pages',
       'rating',
       'is_featured',
       'is_active',
       'category_id'
       
   ];


   protected $casts = [
       'price' => 'decimal:2',
       'file_size' => 'integer',
       'is_featured' => 'boolean',
       'is_active' => 'boolean',
   ];
   public function wishers()
   {
       return $this->belongsToMany(\App\Models\User::class, 'wishlist', 'book_id', 'user_id')
                   ->withTimestamps();
   }


   public function category()
   {
       return $this->belongsTo(Category::class);
   }
   

   public function getFileSizeHumanReadableAttribute()
   {
       if (!$this->file_size) return null;
      
       $bytes = $this->file_size;
       $units = ['B', 'KB', 'MB', 'GB'];
       $i = 0;
      
       while ($bytes >= 1024 && $i < count($units) - 1) {
           $bytes /= 1024;
           $i++;
       }
      
       return round($bytes, 2) . ' ' . $units[$i];
   }
}
