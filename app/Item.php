<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function taxes()
    {
        return $this->BelongsToMany(Tax::class, 'item_taxes')->withTimestamps();
    }
}
