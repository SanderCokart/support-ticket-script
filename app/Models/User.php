<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_admin',
        'telephonenumber',
    ];

    protected $appends = [
        'full_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn() => $this->first_name . ' ' . $this->last_name,
        );
    }

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assignee_id');
    }

    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereIsAdmin(true);
    }
}
