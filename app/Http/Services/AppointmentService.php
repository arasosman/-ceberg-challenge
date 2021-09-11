<?php

namespace App\Http\Services;

use App\Http\Requests\Appointment\AppointmentRequest;
use App\Http\Requests\Appointment\AppointmentStoreRequest;
use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryContract;
use Illuminate\Database\Eloquent\Model;

class AppointmentService
{
    private AppointmentRepositoryContract $appointmentRepository;

    public function __construct(AppointmentRepositoryContract $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function index(AppointmentRequest $request)
    {
        $params = $request->validated();
        $params = array_merge($params, ['with_server' => ['contact', 'consultant']]);

        return $this->appointmentRepository->search($params);
    }

    public function store(AppointmentStoreRequest $request): ?Model
    {
        return $this->appointmentRepository->create($request->validated());
    }

    public function show(int $appointmentId): ?Model
    {
        $appointment = $this->appointmentRepository->find($appointmentId);
        abort_unless(boolval($appointment), 404);
        return $appointment;
    }

    public function update(Appointment $appointment, array $data): ?Model
    {
        return $this->appointmentRepository->update($appointment, $data);
    }

    public function destroy(Appointment $appointment): bool
    {
        return $this->appointmentRepository->destroy($appointment);
    }
}
