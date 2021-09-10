<?php

namespace App\Http\Services;

use App\Http\Requests\Contact\ContactRequest;
use App\Http\Requests\Contact\ContactStoreRequest;
use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryContract;
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
        return $this->contactRepository->create($request->validated());
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
}
