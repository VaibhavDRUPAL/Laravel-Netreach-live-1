<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(!($request->has('startDate') && $request->has('endDate'))){
            abort(400);
        }
        $user = $request->user();


        $attendances = Attendance::where('user_id', '=', $user->id)
                                    ->where('date', '>=', $request->startDate)
                                    ->where('date', '<=', $request->endDate)
                                    ->orderBy('date')
                                    ->get();

        return $attendances;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attendance = Attendance::firstOrCreate(
            ['date'=> $request->date, 'user_id'=> $request->user()->id],
            ['hours'=> $request->hours]);
        $attendance->hours = $request->hours;
        $attendance->save();
        return $attendance;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
