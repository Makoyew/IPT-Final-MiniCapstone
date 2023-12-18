<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }
}
