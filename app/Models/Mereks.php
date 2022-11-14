<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mereks extends Model
{
    use HasFactory;
    protected $table   = "mereks";
    protected $guarded = ['id'];
}
