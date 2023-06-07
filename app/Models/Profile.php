<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
   use HasFactory;
   use softDeletes;
   protected $fillable = [
   'member_id',
   'is_married',
   'hasband_id',
   'is_hasband_from_outside',
   'mobile',
   'city',
   ];
}
