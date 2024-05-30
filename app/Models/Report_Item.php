<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id',
        'subjectitem_id',
        'score',
        'grade_id',
    ];
}
