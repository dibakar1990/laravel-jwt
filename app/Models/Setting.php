<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public function filePathUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->value ? asset('storage/'.$this->value) : null
        );
    }

    public function favIconUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->fav_icon ? asset('storage/'.$this->fav_icon) : null
        );
    }

}
