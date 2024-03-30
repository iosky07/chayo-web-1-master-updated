<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $keyType = 'integer';

    protected $fillable = ['user_id', 'created_at', 'activity', 'access'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('user_id', 'like', '%'.$query.'%');
    }
}
