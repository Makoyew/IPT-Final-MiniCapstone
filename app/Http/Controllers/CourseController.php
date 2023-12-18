<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Events\UserLog;
use App\Listeners\LogListener;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course')); // Change 'courses' to 'course'
    }


    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->all());

        $log_entry = Auth::user()->name . " edited a course " . $course->title;
        event(new UserLog($log_entry));

        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course = Course::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        $log_entry = Auth::user()->name . " added a course " . $course->title;
        event(new UserLog($log_entry));

        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        $log_entry = Auth::user()->name . " deleted a course " . $course->title;
        event(new UserLog($log_entry));

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }

}
