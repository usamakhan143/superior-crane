<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function rigger_ticket()
    {
        return $this->belongsTo(Job::class, 'rigger_id');
    }

    public function pay_duty()
    {
        return $this->belongsTo(Job::class, 'payduty_id');
    }

    public function transportation_ticket()
    {
        return $this->belongsTo(Job::class, 'transportation_id');
    }
}
