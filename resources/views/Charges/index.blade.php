@extends('base')

@include('navbar')

@section('content')
    <div class="container">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="table-heading mb-0">Summary of Charges</h2>
                @role('administrator')
                <button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#createChargeModal">
                    Create Charge
                </button>
                @endrole
            </div>

            @if(auth()->user()->hasRole('administrator'))
                {{-- Display all courses and charges for administrators --}}
                @forelse($courses as $course)
                    @if($course->charges && count($course->charges) > 0)
                        <div class="table-wrapper">
                            <table class="custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        @role('administrator')
                                        <th>ID</th>
                                        @endrole
                                        <th>Course</th>
                                        <th>Subject Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->charges as $charge)
                                        <tr>
                                            @role('administrator')
                                            <td>{{ $charge->id }}</td>
                                            @endrole
                                            <td>{{ $course->title }}</td>
                                            <td>{{ $charge->charge_description }}</td>
                                            <td>{{ $charge->amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="total-amount text-end mt-3">
                                <strong>Total Amount: {{ $courseTotalAmounts[$course->id] }}</strong>
                            </div>
                        </div>
                    @else
                        <p class="text-center">No charges found for {{ $course->title }}.</p>
                    @endif
                @empty
                    <p class="text-center">No courses available.</p>
                @endforelse
            @else
                {{-- Display only enrolled courses and charges for students --}}
                @forelse(auth()->user()->enrollments as $enrollment)
                    @if($enrollment->course->charges && count($enrollment->course->charges) > 0)
                        <div class="table-wrapper">
                            <table class="custom-table">
                                <thead class="custom-thead">
                                    <tr>
                                        <th>Course</th>
                                        <th>Subject Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrollment->course->charges as $charge)
                                        <tr>
                                            <td>{{ $enrollment->course->title }}</td>
                                            <td>{{ $charge->charge_description }}</td>
                                            <td>{{ $charge->amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="total-amount text-end mt-3">
                                <strong>Total Amount: {{ $courseTotalAmounts[$enrollment->course->id] }}</strong>
                            </div>
                        </div>
                    @else
                        <p class="text-center">No charges found for {{ $enrollment->course->title }}.</p>
                    @endif
                @empty
                    <p class="text-center">You are not enrolled in any courses.</p>
                @endforelse
            @endif
        </div>

        <div class="modal fade" id="createChargeModal" tabindex="-1" aria-labelledby="createChargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createChargeModalLabel">Create Charge</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('charges.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="course_id" class="form-label">Select Course:</label>
                                <select class="form-select" id="course_id" name="course_id" required>
                                    <option value="" selected disabled>Select a Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="charge_description" class="form-label">Charge Description:</label>
                                <input type="text" class="form-control" id="charge_description" name="charge_description" required>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount:</label>
                                <input type="text" class="form-control" id="amount" name="amount" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach($courses as $course)
                var totalAmount_{{ $course->id }} = {{ $courseTotalAmounts[$course->id] }};
                document.querySelector('.total-amount_{{ $course->id }} strong').textContent = 'Total Amount: ' + totalAmount_{{ $course->id }}.toFixed(2);
            @endforeach
        });
    </script>
@endsection

<style>

    .table-container {
        margin-bottom: 2rem;
    }

    .table-heading {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .btn-primary {
        padding: 0.5rem 1rem;
        background-color: #3490dc;
        color: #fff;
        text-decoration: none;
        border-radius: 0.25rem;
        display: inline-block;
    }

    .table-wrapper {
        margin-top: 1rem;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .custom-thead {
        background-color: rgb(173, 164, 164);
    }

    .custom-table th,
    .custom-table td {
        padding: 0.75rem;
        text-align: center;
        border: 1px solid #e2e8f0;
    }

    .no-charges-msg {
        text-align: center;
    }
</style>



