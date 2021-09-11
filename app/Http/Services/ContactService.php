<?php

namespace App\Http\Services;

use App\Http\Requests\Contact\ContactRequest;
use App\Http\Requests\Contact\ContactStoreRequest;
use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryContract;
use App\Services\Contracts\GoogleMapServiceContract;
use App\Services\Contracts\PostcodeServiceContract;
use Illuminate\Database\Eloquent\Model;

class ContactService
{
    private ContactRepositoryContract $contactRepository;

    public function __construct(ContactRepositoryContract $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index(ContactRequest $request)
    {
        $params = $request->validated();
        $params = array_merge($params, ['with_server' => ['appointments']]);

        return $this->contactRepository->search($params);
    }

    public function store(ContactStoreRequest $request): ?Model
    {
        $address = null;
        if (!$request->has('address') && $request->has('postcode')) {
            $address['address'] = $this->getAddressByPostcode($request);
        }
        $data = $request->validated();
        if ($address) {
            $data = array_merge($data, $address);
        }
        return $this->contactRepository->create($data);
    }

    public function show(int $contactId): ?Model
    {
        $contact = $this->contactRepository->find($contactId);
        abort_unless(boolval($contact), 404);
        return $contact;
    }

    public function update(Contact $contact, array $data): ?Model
    {
        return $this->contactRepository->update($contact, $data);
    }

    public function destroy(Contact $contact): bool
    {
        return $this->contactRepository->destroy($contact);
    }

    /**
     * @param ContactStoreRequest $request
     * @return string
     */
    private function getAddressByPostcode(ContactStoreRequest $request): string
    {
        /** @var PostcodeServiceContract $postcodeService */
        $postcodeService = app(PostcodeServiceContract::class);
        /** @var GoogleMapServiceContract $googleService */
        $googleService = app(GoogleMapServiceContract::class);

        $detail = $postcodeService->getDetail($request->input("postcode"));
        $coordinates = [
            'latitude' => $detail['latitude'],
            'longitude' => $detail['longitude'],
        ];
        return $googleService->getAddress($coordinates);
    }
}
