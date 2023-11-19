<?php

namespace App\Models\Apis\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forgotpassword extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'token', 'otp'];
}
