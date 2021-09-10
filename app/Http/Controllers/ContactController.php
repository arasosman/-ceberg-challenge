<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ContactRequest;
use App\Http\Requests\Contact\ContactStoreRequest;
use App\Http\Resources\ContactResource;
use App\Http\Services\ContactService;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    private ContactService $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ContactRequest $request
     * @return JsonResponse
     */
    public function index(ContactRequest $request): JsonResponse
    {
        $contacts = $this->contactService->index($request);
        return ContactResource::collection($contacts)->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContactStoreRequest $request
     * @return JsonResponse
     */
    public function store(ContactStoreRequest $request): JsonResponse
    {
        $contact = $this->contactService->store($request);
        if ($contact) {
            return ContactResource::make($contact)->response();
        }
        return response()->json(['error' => "creation error"])->setStatusCode(400);
    }

    /**
     * Display the specified resource.
     *
     * @param int $contactId
     * @return JsonResponse
     */
    public function show(int $contactId): JsonResponse
    {
        $contact = $this->contactService->show($contactId);
        if ($contact) {
            return ContactResource::make($contact)->response();
        }
        return response()->json(['error' => "not found"])->setStatusCode(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContactRequest $request
     * @param int $contactId
     * @return JsonResponse
     */
    public function update(ContactRequest $request, int $contactId): JsonResponse
    {
        /** @var Contact $contact */
        $contact = $this->contactService->show($contactId);

        $updatedContact = $this->contactService->update($contact, $request->validated());
        return ContactResource::make($updatedContact)->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $contactId
     * @return JsonResponse
     */
    public function destroy(int $contactId): JsonResponse
    {
        /** @var Contact $contact */
        $contact = $this->contactService->show($contactId);

        $deleted = $this->contactService->destroy($contact);
        if ($deleted) {
            return response()->json(['message' => 'success'])->setStatusCode(200);
        }
        return response()->json(['message' => 'error'])->setStatusCode(400);
    }
}
