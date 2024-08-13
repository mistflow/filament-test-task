<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * Mass assignable.
     * @var string[] $fillable
     */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
    ];

    /**
     * Project ->> Task
     * @return HasMany|null
     */
    public function tasks():? HasMany
    {
        return $this->hasMany(Task::class);
    }
}
