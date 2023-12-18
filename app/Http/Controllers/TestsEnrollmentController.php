<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\TestEnrollment;

class TestsEnrollmentController extends Controller
{
    public function sendTestNotification() {

        $user = User::first();

        $enrollmentData = [
            'body' => 'You received a new notification',
            'enrollmentText' => 'You have been enrolled',
            'url' => url('/'),
            'thankyou' => 'You have 14 days to enroll to MDC'
        ];

        $user->notify(new TestEnrollment($enrollmentData));

    }
}
