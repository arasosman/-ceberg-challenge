<?php

namespace App\Models;

use Database\Factories\AppointmentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Appointment
 *
 * @method static AppointmentFactory factory(...$parameters)
 * @method static Builder|Appointment newModelQuery()
 * @method static Builder|Appointment newQuery()
 * @method static Builder|Appointment query()
 * @mixin Eloquent
 * @property int $id
 * @property string $address
 * @property string $postcode
 * @property Carbon $appointment_date
 * @property Carbon $out_of_office_date
 * @property Carbon $back_to_office_date
 * @property int $contact_id
 * @property int $consultant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Appointment whereAddress($value)
 * @method static Builder|Appointment whereAppointmentDate($value)
 * @method static Builder|Appointment whereBackToOfficeDate($value)
 * @method static Builder|Appointment whereConsultantId($value)
 * @method static Builder|Appointment whereContactId($value)
 * @method static Builder|Appointment whereCreatedAt($value)
 * @method static Builder|Appointment whereId($value)
 * @method static Builder|Appointment whereOutOfOfficeDate($value)
 * @method static Builder|Appointment wherePostcode($value)
 * @method static Builder|Appointment whereUpdatedAt($value)
 */
class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'postcode',
        'appointment_date',
        'out_of_office_date',
        'back_to_office_date',
        'contact_id',
        'consultant_id'
    ];

    protected $casts = [
        'contact_id' => 'integer',
        'consultant_id' => 'integer',
        'appointment_date' => 'datetime',
        'out_of_office_date' => 'datetime',
        'back_to_office_date' => 'datetime',
    ];
}
