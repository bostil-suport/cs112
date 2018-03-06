<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Provider extends Model
{
    public function User()
    {
        return $this->belongsTo('App\User');
    }

    protected $fillable = [
        'provider', 'provider_id'
    ];

}
