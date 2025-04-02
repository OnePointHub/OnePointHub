<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location',
        'status',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'last_active_at',
        'roles',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_active_at' => 'datetime',
        ];
    }

    protected $with = [
        'roles',
    ];

    protected $appends = [
        'last_active',
        'role',
    ];

    public function getLastActiveAttribute(): string
    {
        if ($this->last_active_at === null) {
            return 'Never';
        } else {
            if ($this->last_active_at->gt(Carbon::now()->subMinutes(10))) {
                return 'Just now';
            } else {
                return $this->last_active_at->diffForHumans();
            }
        }
    }

    public function getRoleAttribute(): string
    {
        return $this->roles()->pluck('name')->first();
    }
}
