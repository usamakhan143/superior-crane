<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payduty extends Model
{
    use HasFactory;

    public function signature()
    {
        return $this->hasOne(File::class, 'payduty_id')->where('file_type', 'signature');
    }
}
