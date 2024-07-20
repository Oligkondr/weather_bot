<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property string $ext_id
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $language_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $is_disable
 * @property int $state
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\City> $cities
 * @property-read int|null $cities_count
 * @method static Builder|Client newModelQuery()
 * @method static Builder|Client newQuery()
 * @method static Builder|Client query()
 * @method static Builder|Client whereCreatedAt($value)
 * @method static Builder|Client whereExtId($value)
 * @method static Builder|Client whereFirstName($value)
 * @method static Builder|Client whereId($value)
 * @method static Builder|Client whereIsDisable($value)
 * @method static Builder|Client whereLanguageCode($value)
 * @method static Builder|Client whereLastName($value)
 * @method static Builder|Client whereState($value)
 * @method static Builder|Client whereUpdatedAt($value)
 * @method static Builder|Client whereUsername($value)
 * @mixin Eloquent
 */
class Client extends Model
{
    use HasFactory;

    public const STATE_COMMAND = 0;
    public const STATE_CITIES = 1;

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class);
    }
}
