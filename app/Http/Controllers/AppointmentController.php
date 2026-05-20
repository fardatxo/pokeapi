<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_name'     => 'required|string',
            'service_price'    => 'required|numeric',
            'service_duration' => 'required|integer',
            'date'             => 'required|date|after_or_equal:today',
            'time'             => 'required|string',
            'client_name'      => 'required|string|max:255',
            'client_phone'     => 'required|string|max:20',
            'client_email'     => 'required|email',
            'notes'            => 'nullable|string',
        ]);

        if ($request->user('sanctum')) {
            $data['user_id'] = $request->user('sanctum')->id;
        }

        $appointment = Appointment::create($data);

        return response()->json($appointment, 201);
    }

    public function index(Request $request)
    {
        $appointments = $request->user()
            ->appointments()
            ->orderByDesc('date')
            ->orderByDesc('time')
            ->get();

        return response()->json($appointments);
    }
}
