<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rigger extends Model
{
    use HasFactory;

    public function signature()
    {
        return $this->hasOne(File::class, 'rigger_id')->where('file_type', 'signature');
    }

    public function images()
    {
        return $this->hasMany(File::class, 'rigger_id')->where('file_type', 'rigger-gallery');
    }

    public function payDuty()
    {
        return $this->hasOne(Payduty::class, 'rigger_id');
    }
}
