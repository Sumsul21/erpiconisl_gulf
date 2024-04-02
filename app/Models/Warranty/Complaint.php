<?php

namespace App\Models\Warranty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $fillable = [
        'issue_date',
        'issue_no',
        'remarks',
        'status',
        'mast_customer_id',
        'user_id',
    ];
}
