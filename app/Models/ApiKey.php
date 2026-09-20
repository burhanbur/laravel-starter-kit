<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'api_keys';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'key_prefix',
        'key_hash',
        'description',
        'application',
        'ip_whitelist',
        'permissions',
        'is_active',
        'rate_limit',
        'last_used_at',
        'expires_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = ['key_hash'];

    protected function casts(): array
    {
        return [
            'ip_whitelist' => 'array',
            'permissions' => 'array',
            'is_active' => 'boolean',
            'rate_limit' => 'integer',
            'last_used_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ApiKey $apiKey): void {
            $apiKey->id ??= (string) uuidv7();
        });
    }

    public static function generate(): string
    {
        $prefix = Str::slug((string) config('app.alias', 'app'), '_') . '_' . Str::lower(Str::random(8));

        return $prefix . '.' . Str::random(48);
    }

    public static function prefixFromRawKey(string $rawKey): string
    {
        return Str::before($rawKey, '.');
    }

    public static function hashRawKey(string $rawKey): string
    {
        return hash('sha256', $rawKey);
    }

    public function isValid(): bool
    {
        return $this->is_active && (!$this->expires_at || !$this->expires_at->isPast());
    }

    public function isIpAllowed(string $ip): bool
    {
        return empty($this->ip_whitelist) || in_array($ip, $this->ip_whitelist, true);
    }

    public function hasPermission(string $permission): bool
    {
        return empty($this->permissions)
            || in_array($permission, $this->permissions, true)
            || in_array('*', $this->permissions, true);
    }

    public function recordUsage(): void
    {
        $this->update(['last_used_at' => now()]);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getMaskedKeyAttribute(): string
    {
        return $this->key_prefix === null ? '' : $this->key_prefix . '.••••••••';
    }
}
