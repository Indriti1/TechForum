<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Conner\Likeable\Likeable;


class Topic extends Model
{
    use HasFactory;
    use Likeable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function firstReply()
    {
        return $this->hasOne(Reply::class)->oldest()->first();
    }
}
