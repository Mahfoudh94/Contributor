<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasUuids;

    protected static function booted()
    {
        parent::booted();
        self::creating(function (Task $task) {
            $task->start_at ??= Carbon::now();
        });
    }

    protected $fillable = [
        'title',
        'description',
        'status',
        'start_at',
    ];
    protected $casts = [
        'status' => TaskStatusEnum::class
    ];
    public $timestamps = false;

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
