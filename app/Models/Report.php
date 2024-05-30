<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        "sudent_id",
        "classroom_id",
        "month",
        "issued_by",
        "update_by",
        "accepted",
        "teacher_cmt",
        "parent_cmt",
        "is_sent",
        "total_score",
        "abs",
        "permission",
        "issued_at"
    ];
}
