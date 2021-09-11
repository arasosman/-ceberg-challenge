<?php

namespace App\Http\Services;

use App\Http\Requests\Appointment\AppointmentRequest;
use App\Http\Requests\Appointment\AppointmentStoreRequest;
use App\Models\Appointment;
use App\Repositories\Contracts\AppointmentRepositoryContract;
use App\Services\Contracts\GoogleMapServiceContract;
use App\Services\Contracts\PostcodeServiceContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AppointmentService
{
    private AppointmentRepositoryContract $appointmentRepository;

    private PostcodeServiceContract $postcodeService;

    private GoogleMapServiceContract $googleService;

    public function __construct(AppointmentRepositoryContract $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;

        $this->postcodeService = app(PostcodeServiceContract::class);

        $this->googleService = app(GoogleMapServiceContract::class);
    }

    public function index(AppointmentRequest $request)
    {
        $params = $request->validated();
        $params = array_merge($params, ['with_server' => ['contact', 'consultant']]);

        return $this->appointmentRepository->search($params);
    }

    public function store(AppointmentStoreRequest $request): ?Model
    {
        $data = $request->validated();
        $result = $this->getDistance($request);

        $data = array_merge($data, [
            'distance' => $result['distance']['value'],
            'out_of_office_date' => Carbon::parse($request->input('appointment_date'))
                ->subSeconds(round($result['duration']['value']))

        ]);

        $resultForReturnDuration = $this->getDistance($request, 1);

        $data = array_merge($data, [
            'back_to_office_date' => Carbon::parse($request->input('appointment_date'))
                ->addSeconds(round($resultForReturnDuration['duration']['value']))
                ->addHour()

        ]);

        return $this->appointmentRepository->create($data);
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

    /**
     * @param AppointmentStoreRequest $request
     * @param int $revert
     * @return array
     */
    private function getDistance(AppointmentStoreRequest $request, int $revert = 0): array
    {
        $detail = $this->postcodeService->getDetail($request->input("postcode"));

        $userDetail = $this->postcodeService->getDetail(auth()->user()->postcode);

        $coordinates1 = [
            'latitude' => $userDetail['latitude'],
            'longitude' => $userDetail['longitude'],
        ];
        $coordinates2 = [
            'latitude' => $detail['latitude'],
            'longitude' => $detail['longitude'],
        ];
        $result = $this->getDistanceResult($coordinates1, $coordinates2, $revert);

        return [
            'distance' => $result['distance'],
            'duration' => $result['duration']
        ];
    }

    /**
     * @param array $coordinates1
     * @param array $coordinates2
     * @param int $revert
     * @return array
     */
    private function getDistanceResult(array $coordinates1, array $coordinates2, int $revert): array
    {
        if ($revert) {
            return $this->googleService->getDistance($coordinates2, $coordinates1);
        }
        return $this->googleService->getDistance($coordinates1, $coordinates2);
    }
}
