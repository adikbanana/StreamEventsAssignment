<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class followers extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subscribers()
{
    return $this->hasMany(subscribers::class, 'follower_name', 'name');
}

public function donations()
{
    return $this->hasMany(donations::class, 'follower_name', 'name');
}

public function merch_sales()
{
    return $this->hasMany(merch_sales::class, 'follower_name', 'name');
}

}
