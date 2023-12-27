<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 *
 * Модель Пользователей
 *
 * Fields
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property string $login
 * @property string $password
 *
 * Relations
 * @property Role $role
 *
 */
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
        'login',
        'password',
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

    /**
     * Связь с созданными объявлениями.
     * Тип связи: Один ко Многим
     *
     * @return HasMany|Advertisement
     */
    public function advertisements(): HasMany|Advertisement
    {
        return $this->hasMany(Advertisement::class);
    }

    /**
     * Связь с сущностью Роль
     * Тип связи: Один ко Многим
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Автоматическое хэширование пароля
     *
     * @param string $value
     * @return string
     */
    public function setPasswordAttribute(string $value): string
    {
        return $this->attributes['password'] = Hash::make($value);
    }
}
