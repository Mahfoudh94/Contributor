<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasUuids;
    protected $fillable = [
        'title',
        'description',
        'manager_id',
        'start_at',
    ];
    protected $casts = [
        'start_at' => 'datetime:m/d H:i',

    ];
    protected $appends = [
        'can_join'
    ];

    protected $withCount = [
        'tasks'
    ];

    protected function canJoin(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => $this->tasks()
                ->where([['status', '=', '0'], ['status', '=', '1']], boolean: 'or')
                ->count() > 0,
        );
    }

    protected function startAt(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => $value ?? $this->tasks
                ->pluck('start_at')
                ->sortBy('start_at')
                ->first(),
            set: fn($value) => $value,
        );
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function repository(): HasOne
    {
        return $this->hasOne(RoomRepo::class);
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'room_user');
    }
}
