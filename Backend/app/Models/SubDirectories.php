<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDirectories extends Model
{
    use HasFactory;
    
    protected $table = 'subdirectories';

    protected $fillable = ['name'];

    public function Url(){
        return $this->hasMany(ShortenedUrl::class);
    }
}
