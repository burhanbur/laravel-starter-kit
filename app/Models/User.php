<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lab404\Impersonate\Models\Impersonate;
// use Kra8\Snowflake\HasSnowflakePrimary;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, Impersonate;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $customClaims = [];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'email_verified_at',
        'is_active',
        'deleted_by',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'is_active' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($user) {
            if (empty($user->id)) {
                $user->id = (string) uuidv7();
            }
        });
    }

    public function hasChild()
    {
        return false;
    }

    /**
     * Get the roles for the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
                    ->withTimestamps();
    }

    public function belongToRoles()
    {
        return $this->hasMany(UserRole::class, 'user_id');
    }

    /**
     * Get the activities for the user.
     */
    public function activities()
    {
        return $this->hasMany(UserActivity::class, 'user_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function setCustomClaims(array $claims): void
    {
        $this->customClaims = $claims ?? null;
    }

    public function getJWTCustomClaims()
    {
        return $this->customClaims ?? [];
    }

    /**
     * Assign role(s) to the user.
     *
     * @param string|array|Role|\Illuminate\Support\Collection $roles
     * @return $this
     */
    public function assignRole($roles)
    {
        $roles = $this->convertToRoleIds($roles);

        foreach ($roles as $roleId) {
            if (!$this->roles()->where('role_id', $roleId)->exists()) {
                $this->roles()->attach($roleId, [
                    'created_by' => auth()->id() ?: $this->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Refresh the model to reflect the changes
        $this->load('roles');

        return $this;
    }

    /**
     * Remove role(s) from the user.
     *
     * @param string|array|Role|\Illuminate\Support\Collection $roles
     * @return $this
     */
    public function removeRole($roles = null)
    {
        if (is_null($roles)) {
            $this->roles()->detach();
            return $this;
        }

        $roles = $this->convertToRoleIds($roles);

        $this->roles()->detach($roles);

        // Refresh the model to reflect the changes
        $this->load('roles');

        return $this;
    }

    /**
     * Sync roles with the user (removes all current roles and adds new ones).
     *
     * @param string|array|Role|\Illuminate\Support\Collection $roles
     * @return $this
     */
    public function syncRoles($roles)
    {
        $roles = $this->convertToRoleIds($roles);

        $syncData = [];
        foreach ($roles as $roleId) {
            $syncData[$roleId] = [
                'created_by' => auth()->id() ?: $this->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $this->roles()->sync($syncData);

        // Refresh the model to reflect the changes
        $this->load('roles');

        return $this;
    }

    /**
     * Check if user has a specific role.
     *
     * @param string|array|Role $roles
     * @return bool
     */
    public function hasRole($roles): bool
    {
        if (is_string($roles) && strpos($roles, '|') !== false) {
            $roles = explode('|', $roles);
        }

        if (is_string($roles)) {
            return $this->roles->contains(function ($role) use ($roles) {
                return $role->code === $roles || $role->name === $roles || $role->id === $roles;
            });
        }

        if ($roles instanceof Role) {
            return $this->roles->contains('id', $roles->id);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
            return false;
        }

        return false;
    }

    /**
     * Check if user has any of the given roles.
     *
     * @param string|array|Role $roles
     * @return bool
     */
    public function hasAnyRole($roles): bool
    {
        return $this->hasRole($roles);
    }

    /**
     * Check if user has all of the given roles.
     *
     * @param string|array|Role|\Illuminate\Support\Collection $roles
     * @return bool
     */
    public function hasAllRoles($roles): bool
    {
        if (is_string($roles) && strpos($roles, '|') !== false) {
            $roles = explode('|', $roles);
        }

        if (is_string($roles)) {
            $roles = [$roles];
        }

        if ($roles instanceof Role) {
            $roles = [$roles];
        }

        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Convert various role formats to role IDs.
     *
     * @param string|array|Role|\Illuminate\Support\Collection $roles
     * @return array
     */
    protected function convertToRoleIds($roles): array
    {
        if ($roles instanceof Role) {
            return [$roles->id];
        }

        if (is_string($roles) && strpos($roles, '|') !== false) {
            $roles = explode('|', $roles);
        }

        if (is_string($roles)) {
            $role = Role::where('code', $roles)
                ->orWhere('name', $roles)
                ->orWhere('id', $roles)
                ->first();
            
            return $role ? [$role->id] : [];
        }

        if (is_array($roles) || $roles instanceof \Illuminate\Support\Collection) {
            $roleIds = [];
            
            foreach ($roles as $role) {
                if ($role instanceof Role) {
                    $roleIds[] = $role->id;
                } elseif (is_string($role)) {
                    $foundRole = Role::where('code', $role)
                        ->orWhere('name', $role)
                        ->orWhere('id', $role)
                        ->first();
                    
                    if ($foundRole) {
                        $roleIds[] = $foundRole->id;
                    }
                }
            }
            
            return $roleIds;
        }

        return [];
    }

    public function getRoleIdsAttribute()
    {
        return $this->roles()->pluck('id')->toArray();
    }
}
