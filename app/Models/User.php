<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'company_id'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function company() { return $this->belongsTo(Company::class); }
    public function urls() { return $this->hasMany(Url::class); }

    public function canCreateUrls(): bool {
        return in_array($this->role, ['member']);
    }

    public function canViewCompanyUrls(): bool {
        return $this->role === 'admin';
    }

    public function isSuperAdmin(): bool {
        return $this->role === 'superadmin';
    }

    public function canInviteRole(string $targetRole): bool {
        if ($this->isSuperAdmin() && $targetRole === 'admin') return false;
        if ($this->role === 'admin' && in_array($targetRole, ['admin', 'member'])) return false;
        return true;
    }
}
