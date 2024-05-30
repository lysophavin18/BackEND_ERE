<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject_Item extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "max_score",
        "passing_score",
        "subject_id",
        "classroom_id"
    ];
}
