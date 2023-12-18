<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charge;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Events\UserLog;
use App\Listeners\LogListener;


class ChargeController extends Controller
{
    public function index()
{
    $courses = Course::with('charges')->get();

    $courseTotalAmounts = [];
    foreach ($courses as $course) {
        $courseTotalAmounts[$course->id] = $course->charges->sum('amount');
    }

    return view('charges.index', compact('courses', 'courseTotalAmounts'));
}

    public function show($id)
    {
        $charge = Charge::findOrFail($id);

        return view('charges.show', compact('charge'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'charge_description' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $course = Course::findOrFail($validatedData['course_id']);

        $existingCharge = Charge::where('course_id', $validatedData['course_id'])
                                ->where('charge_description', $validatedData['charge_description'])
                                ->first();

        if ($existingCharge) {
            $existingCharge->update(['amount' => $existingCharge->amount + $validatedData['amount']]);
        } else {
            Charge::create($validatedData);
        }

        $log_entry = Auth::user()->name . " Added a Charge in " . $course->title;
        event(new UserLog($log_entry));

        return redirect()->route('charges.index')->with('success', 'Charge created or updated successfully');
    }

}
