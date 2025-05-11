<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    protected $table = 'apiJobs';
    protected $fillable = [
        'title',
        'company',
        'location',
        'description',
        'status',
        'posted_at',
        'closing_at',
        'job_type',
        'salary',
        'contact_email'
    ];
}
