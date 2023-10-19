<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;

/**
 * Class Role
 * @package App\Models
 *
 * Модель Ролей
 *
 * Fields
 * @property-read int $id
 * @property string $name
 * @property Date $created_at
 * @property Date $updated_at
 *
 * Relations
 * @property User[] $users
 */
class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Связь с сущностью Пользователь
     * Тип: Один ко Многим
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
