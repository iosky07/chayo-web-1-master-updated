<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $keyType = 'integer';

    protected $fillable = ['id', 'name', 'address', 'phone_number', 'packet_tag_id', 'registration_date', 'identity_picture', 'location_picture', 'longitude', 'latitude', 'identity_number', 'user_id', 'bill', 'total_bill', 'isolate_date', 'status', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function packetTag()
    {
        return $this->hasMany('App\Models\PacketTag');
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%'.$query.'%');
    }
}
