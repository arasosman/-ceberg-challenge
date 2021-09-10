<?php

namespace App\Models;

use Database\Factories\ContactFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Contact
 *
 * @method static ContactFactory factory(...$parameters)
 * @method static Builder|Contact newModelQuery()
 * @method static Builder|Contact newQuery()
 * @method static Builder|Contact query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string|null $postcode
 * @property string|null $address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Contact whereAddress($value)
 * @method static Builder|Contact whereCreatedAt($value)
 * @method static Builder|Contact whereEmail($value)
 * @method static Builder|Contact whereId($value)
 * @method static Builder|Contact whereName($value)
 * @method static Builder|Contact wherePhone($value)
 * @method static Builder|Contact wherePostcode($value)
 * @method static Builder|Contact whereUpdatedAt($value)
 * @property-read Collection|Appointment[] $appointments
 * @property-read int|null $appointments_count
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'postcode'
    ];

    /**
     * @return HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
