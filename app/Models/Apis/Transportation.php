<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    use HasFactory;

    public function customerSignature()
    {
        return $this->hasOne(File::class, 'transportation_id')->where('file_type', 'customer-signature');
    }

    public function driverSignature()
    {
        return $this->hasOne(File::class, 'transportation_id')->where('file_type', 'driver-signature');
    }

    public function shipperSignature()
    {
        return $this->hasOne(File::class, 'transportation_id')->where('file_type', 'shipper-signature');
    }

    public function images()
    {
        return $this->hasMany(File::class, 'transportation_id')->where('file_type', 'transportation-gallery');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function getTransportationTicketPdf()
    {
        return $this->hasOne(File::class, 'transportation_id')->where('file_type', 'transportation-pdf');
    }
}
