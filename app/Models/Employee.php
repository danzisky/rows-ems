<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'job_title',
        'salary'
    ];

    public function certifications()
    {
        return $this->belongsToMany(Certification::class);
    }
}
