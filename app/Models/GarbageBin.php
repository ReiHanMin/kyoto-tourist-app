<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarbageBin extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'latitude', 'longitude'];
}
