<?php

namespace App\Models;

use App\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * Mass assignable.
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'project_id',
        'user_id',
    ];

    /**
     * Casts.
     * @var array $casts
     */
    protected $casts = [
        'status' => TaskStatus::class,
    ];

    /**
     * User ->> Task
     * @return BelongsTo|null
     */
    public function user():? BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Project ->> Task
     * @return BelongsTo|null
     */
    public function project():? BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
