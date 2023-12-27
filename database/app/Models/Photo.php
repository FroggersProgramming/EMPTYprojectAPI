<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Photo
 * @package App\Models
 *
 * Модель Фотографий
 *
 * Fields
 * @property-read int $id
 * @property string $name
 * @property string $URL
 *
 * Relations
 * @property Advertisement $advertisement
 */
class Photo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'URL',
    ];

    /**
     * Связь с Объявлениями (Advertisement)
     * Тип связи: Один ко Мноигим
     *
     * @return BelongsTo|Advertisement
     */
    public function Advertisement(): BelongsTo|Advertisement
    {
        return $this->belongsTo(Advertisement::class);
    }
}
