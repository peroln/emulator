<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const DEFAULT_ROLE = 4;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
