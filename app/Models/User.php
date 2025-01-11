<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use UserRoles;
use UserStatuses;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'user_status_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    #region SUPER ADMIN
    /**
     * Checks if user is a super admin
     *
     * @return boolean
     */
    public function isSuperAdmin(): bool
    {
        return (bool) $this->user_role_id === UserRoles::SUPER;
    }

    /**
     * Create admin.
     *
     * @param array $details
     * @return array
     */
    public function createSuperAdmin(array $details): self
    {
        $user = new self($details);

        if ($this->superAdminExists()) {
            throw new Exception("Only one Superman is allowed!");
        }

        $user->user_role_id = UserRoles::SUPER;
        $user->user_status_id = UserStatuses::ACTIVE;

        $user->save();

        return $user;
    }

    /**
     * Checks if super admin exists
     *
     * @return integer
     */
    public function superAdminExists(): int
    {
        return self::where('user_role_id', UserRoles::SUPER)->count();
    }

    #endregion

    public function userStatus(): BelongsTo
    {
        return $this->belongsTo(UserStatus::class, 'user_status_id');
    }
}
