<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->BelongsToMany(Item::class, 'item_taxes')->withTimestamps();
    }
}
