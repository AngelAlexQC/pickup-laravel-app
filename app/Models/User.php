<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Scopes\Searchable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasApiTokens;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'dni',
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'meta',
    ];

    protected $searchableFields = ['*'];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function my_teams()
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    public function tickets_recivied()
    {
        return $this->hasMany(Ticket::class, 'reciever_id');
    }

    public function tickets_sended()
    {
        return $this->hasMany(Ticket::class, 'sender_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'driver_id');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_member');
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }
}
