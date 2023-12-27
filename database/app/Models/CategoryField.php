<?php

namespace App\Models;

use App\Events\CategoryFieldDeleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Date;

/**
 * Class CategoryField
 * @package App\Models
 *
 * Fields
 * @property-read int $id
 * @property string $name
 * @property string $value
 * @property Date $created_at
 * @property Date $updated_at
 *
 * Relations
 * @property Category[] $category
 */
class CategoryField extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
    ];

    /**
     * Связь с Категориями
     * Тип связи: Многие ко Многим
     *
     * @return BelongsToMany|Category[]
     */
    public function category(): BelongsToMany|Category
    {
        return $this->belongsToMany(
            Category::class,
            'category_category_field',
            'category_field_id'
        );
    }

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'deleted' => CategoryFieldDeleted::class,
    ];
}
