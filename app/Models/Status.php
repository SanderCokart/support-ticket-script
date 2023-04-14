<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;

    public const PENDING = ['title' => 'Pending', 'id' => 1];
    public const IN_PROGRESS = ['title' => 'In Progress', 'id' => 2];
    public const RESOLVED = ['title' => 'Resolved', 'id' => 3];

    public $timestamps = false;

    protected $fillable = [
        'title',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
