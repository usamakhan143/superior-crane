<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function images()
    {
        return $this->hasMany(File::class, 'job_id')->where('file_type', 'job-gallery');;
    }
}
