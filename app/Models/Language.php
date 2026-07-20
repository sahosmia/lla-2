<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model {

    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static function booted() {
        static::addGlobalScope(new ActiveScope);
    }
}
