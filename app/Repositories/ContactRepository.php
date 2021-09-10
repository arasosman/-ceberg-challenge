<?php

namespace App\Repositories;

use App\Repositories\Contracts\ContactRepositoryContract;
use Illuminate\Support\Str;

class ContactRepository extends BaseRepository implements ContactRepositoryContract
{
    public function search(array $params = [])
    {
        $defaultValues = [
            'id' => null,
            'name' => null,
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
            'name',
            'email',
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
        $this->query->where('contacts.id', $value);
    }

    protected function searchName($value)
    {
        $this->query->where('contacts.name', 'like', '%' . $value . '%');
    }

    protected function searchEmail($value)
    {
        $this->query->where('contacts.email', 'like', '%' . $value . '%');
    }
}
