<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{

    public function attendances()
    {
        return response()->json([
            'message' => 'success',
            'data' => Auth::user()->attendances
        ]);
    }

    public function clockIn(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $checkAttendance = Attendance::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        if ($checkAttendance->type != 'clock_out') {
            return response()->json([
                'message' => 'You have not clocked out yet',
            ], 400);
        }

        $data = Attendance::create([
            'user_id' => auth()->user()->id,
            'ip_address' => $request->ip(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'type' => 'clock_in',
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function clockOut(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $checkAttendance = Attendance::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        if ($checkAttendance->type != 'clock_in') {
            return response()->json([
                'message' => 'You have not clocked in yet',
            ], 400);
        }

        $data = Attendance::create([
            'user_id' => auth()->user()->id,
            'ip_address' => $request->ip(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'type' => 'clock_out',
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }
}
