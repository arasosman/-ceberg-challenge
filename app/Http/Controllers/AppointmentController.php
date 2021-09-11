<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\AppointmentRequest;
use App\Http\Requests\Appointment\AppointmentStoreRequest;
use App\Http\Resources\AppointmentResource;
use App\Http\Services\AppointmentService;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    private AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param AppointmentRequest $request
     * @return JsonResponse
     */
    public function index(AppointmentRequest $request): JsonResponse
    {
        $appointments = $this->appointmentService->index($request);
        return AppointmentResource::collection($appointments)->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AppointmentStoreRequest $request
     * @return JsonResponse
     */
    public function store(AppointmentStoreRequest $request): JsonResponse
    {
        $appointment = $this->appointmentService->store($request);
        if ($appointment) {
            return AppointmentResource::make($appointment)->response();
        }
        return response()->json(['error' => "creation error"])->setStatusCode(400);
    }

    /**
     * Display the specified resource.
     *
     * @param int $appointmentId
     * @return JsonResponse
     */
    public function show(int $appointmentId): JsonResponse
    {
        $appointment = $this->appointmentService->show($appointmentId);
        if ($appointment) {
            return AppointmentResource::make($appointment)->response();
        }
        return response()->json(['error' => "not found"])->setStatusCode(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AppointmentRequest $request
     * @param int $appointmentId
     * @return JsonResponse
     */
    public function update(AppointmentRequest $request, int $appointmentId)
    {
        /** @var Appointment $appointment */
        $appointment = $this->appointmentService->show($appointmentId);

        $updatedContact = $this->appointmentService->update($appointment, $request->validated());
        return AppointmentResource::make($updatedContact)->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $appointmentId
     * @return JsonResponse
     */
    public function destroy(int $appointmentId): JsonResponse
    {
        /** @var Appointment $appointment */
        $appointment = $this->appointmentService->show($appointmentId);

        $deleted = $this->appointmentService->destroy($appointment);
        if ($deleted) {
            return response()->json(['message' => 'success'])->setStatusCode(200);
        }
        return response()->json(['message' => 'error'])->setStatusCode(400);
    }
}
