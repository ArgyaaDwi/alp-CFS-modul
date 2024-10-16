<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'name',
        'email',
        'password',
        'no_telephone',
        'distributor_id',
        'role_id',
        'address',
        'is_verified',
        'is_active',
        'profile_pic',
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
    ];
    public function distributor()
    {
        return $this->belongsTo(MainDistributor::class,  'distributor_id', 'id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }
    public function complaints()
    {
        return $this->hasMany(Complaints::class, 'user_id', 'id');
    }
}
