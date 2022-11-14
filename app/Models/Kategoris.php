<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoris extends Model
{
    use HasFactory;
    protected $table = "kategoris";
    protected $guarded = ['id'];
}
