<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateMonth extends Model
{
    use HasFactory;

    protected $keyType = 'integer';

    protected $fillable = ['id', 'save_date_per_month', 'created_at', 'updated_at'];
}
