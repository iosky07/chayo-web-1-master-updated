<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketTag extends Model
{
    use HasFactory;

    protected $keyType = 'integer';

    protected $fillable = ['title', 'created_at', 'updated_at'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('title', 'like', '%'.$query.'%');
    }
}
