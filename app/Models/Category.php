<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;

/**
 * Class Category
 * @package App\Models
 *
 * Модель категорий
 *
 * Fields
 * @property-read int $id
 * @property string $name
 * @property int $parent_id
 * @property Date $created_at
 * @property Date $updated_at
 *
 * Relations
 * @property Category $parent
 * @property Category[] $children
 * @property CategoryField[] $categoryFields
 */
class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'parent_id',
    ];

    /**
     * Связь с родительской категорией
     * Тип связи: Один ко Многим
     *
     * @return HasMany
     */
    public function parent(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Связь с дочерними категориями
     * Тип связи: Один ко Мноигм
     *
     * @return BelongsTo
     */
    public function children(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Связь с Полями категорий
     * Тип связи: Многие ко Многим
     *
     * @return BelongsToMany|CategoryField[]
     */
    public function categoryFields(): BelongsToMany|CategoryField
    {
        return $this->belongsToMany(
            CategoryField::class,
            'category_category_field',
            'category_id'
        );
    }
}
