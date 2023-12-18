<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Events\UserLog;
use App\Listeners\LogListener;
use App\Notifications\TestEnrollment;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::all();
        return view('enrollments.index', compact('enrollments'));
    }

    public function show($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        return view('enrollments.show', compact('enrollment'));
    }

    public function enroll($courseId)
    {
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        try {
            $enrollment = auth()->user()->enrollments()->create([
                'course_id' => $course->id,
                'study_load' => 0,
            ]);

            session()->flash('success', 'Enrolled successfully');

            $log_entry = Auth::user()->name . " enrolled a course " . $course->title;
            event(new UserLog($log_entry));

            return redirect()->route('courses.index');
        } catch (\Exception $e) {
            \Log::error('Enrollment error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            session()->flash('error', 'Internal Server Error');

            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function unenroll($courseId)
    {
        $course = Course::findOrFail($courseId);
        $enrollment = auth()->user()->enrollments()->where('course_id', $course->id)->first();

        if ($enrollment) {
            $enrollment->delete();

            session()->flash('success', 'Unenrolled successfully');

            $log_entry = Auth::user()->name . " unenrolled a course " . $course->title;
            event(new UserLog($log_entry));
            return redirect()->back();
        }

        session()->flash('error', 'Enrollment not found');

        return redirect()->back();
    }

}
