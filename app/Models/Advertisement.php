<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Advertisement
 * @package App\Models
 *
 * Модель объявлений
 *
 * Fields
 * @property-read int $id
 * @property string $title
 * @property string $description
 * @property string $location
 *
 * Relations
 * @property CategoryField[] $categoryFields
 * @property Photo[] $photos
 */
class Advertisement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'location',
    ];

    /**
     * Связь с пользователем, создавшим объявление.
     * Тип связи: Один ко Многим
     *
     * @return BelongsTo|User[]
     */
    public function user(): BelongsTo|User
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь с полями категории.
     * Тип связи: Многие ко Многим
     *
     * @return BelongsToMany|CategoryField[]
     */
    public function categoryFields(): BelongsToMany|CategoryField
    {
        return $this->belongsToMany(
            CategoryField::class,
            'advertisement_category_field',
            'advertisement_id',
        );
    }

    /**
     * Связь с фотографиями.
     * Тип связи: Один ко Многим
     *
     * @return HasMany|Photo[]
     */
    public function photos(): HasMany|Photo
    {
        return $this->hasMany(Photo::class);
    }
}
