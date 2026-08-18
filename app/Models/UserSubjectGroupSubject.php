<?php

namespace App\Models;

use App\Models\Scopes\PositionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class UserSubjectGroupSubject extends Model {
    use HasFactory;

    public $timestamps = false;


    protected static function booted() {
        static::addGlobalScope(new PositionScope);
    }

    public $guarded = [];

    public function subject(): BelongsTo {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function group(): HasOneThrough {
        return $this->hasOneThrough(SubjectGroup::class, UserSubjectGroup::class, 'id', 'id', 'user_subject_group_id', 'subject_group_id');
    }

    public function userSubjectGroup() {
        return $this->belongsTo(UserSubjectGroup::class, 'user_subject_group_id');
    }

    public function coupons(): MorphMany|null {
        if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')) {
            return $this->morphMany(\Modules\KuponDeal\Models\Coupon::class, 'couponable');
        }
        return null;
    }
}
