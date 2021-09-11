<?php

namespace App\Repositories;

use App\Repositories\Contracts\AppointmentRepositoryContract;
use Illuminate\Support\Str;

class AppointmentRepository extends BaseRepository implements AppointmentRepositoryContract
{
    public function search(array $params = [])
    {
        $defaultValues = [
            'id' => null,
            'name' => null,
            'postcode' => null,
            'address' => null,
            'appointment_date' => null,
            'out_of_office_date' => null,
            'back_to_office_date' => null,
            'contact_id' => null,
            'consultant_id' => null,
            'page' => 1,
            'per_page' => 100,
            'with_pagination' => "active",
            'with' => null,
            'order_by' => "id",
            'order_type' => 'desc'
        ];
        $searchParams = array_filter(array_merge($defaultValues, array_filter($params)));

        $this->query = $this->getModel()->newQuery();

        $searchableParams = [
            'id',
            'postcode',
            'appointment_date',
            'contact_id',
            'consultant_id',
        ];

        foreach ($searchableParams as $value) {
            if (empty($searchParams[$value])) {
                continue;
            }

            $method = 'search' . Str::studly($value);

            if (method_exists($this, $method)) {
                $this->$method($searchParams[$value]);
            }
        }

        return parent::search($searchParams);
    }

    protected function searchId($value)
    {
        $this->query->where('appointments.id', $value);
    }

    protected function searchPostcode($value)
    {
        $this->query->where('appointments.postcode', 'like', '%' . $value . '%');
    }

    protected function searchAppointmentDate($value)
    {
        $this->query->whereDate('appointments.appointment_date', '=', $value);
    }
}
