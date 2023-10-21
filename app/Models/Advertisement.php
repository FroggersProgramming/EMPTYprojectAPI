<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
 * @property Tag[] $tags
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
     * Связь с тэгами.
     * Тип связи: Многие ко Многим
     *
     * @return BelongsToMany|Tag[]
     */
    public function tags(): BelongsToMany|Tag
    {
        return $this->belongsToMany(Tag::class);
    }
}
