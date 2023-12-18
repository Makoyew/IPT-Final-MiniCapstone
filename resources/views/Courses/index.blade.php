@extends('base')

@include('navbar')

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success mt-5" id="success-message">
                {{ Session::get('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('success-message').style.display = 'none';
                }, 3000);
            </script>
        @endif
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="table-heading mb-0">Courses Available</h2>
                @role('administrator')
                <button type="button" class="btn btn-primary mt-5 create-course-btn" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                    Create Course
                </button>
                @endrole
            </div>

            <div class="table-wrapper">
                <table class="custom-table">
                    <thead class="custom-thead">
                        <tr>
                            @role('administrator')
                            <th>ID</th>
                            @endrole
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr>
                                @role('administrator')
                                <td>{{ $course->id }}</td>
                                @endrole
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->description }}</td>
                                <td>
                                   @role('administrator')
                                   <button class="btn btn-sm btn-success" title="Edit" data-bs-toggle="modal" data-bs-target="#createEditCourseModal" data-course-id="{{ $course->id }}" data-course-title="{{ $course->title }}" data-course-description="{{ $course->description }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="openDeleteModal({{ $course->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endrole
                                @role('student')
                                @if(auth()->check())
                                    @if(auth()->user()->enrollments->contains('course_id', $course->id))
                                        <button class="btn btn-danger" onclick="unenrollCourse({{ $course->id }})">Unenroll</button>
                                    @else
                                        <button class="btn btn-success" onclick="enrollCourse({{ $course->id }})">Enroll</button>
                                    @endif
                                @endif
                                @endrole
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="no-courses-msg text-center">No courses found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCourseModalLabel">Create Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('courses.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="courseName" class="form-label">Course Name:</label>
                            <input type="text" class="form-control" id="courseName" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="courseDescription" class="form-label">Course Description:</label>
                            <textarea class="form-control" id="courseDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createEditCourseModal" tabindex="-1" aria-labelledby="createEditCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCourseModalLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCourseForm" method="post">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label for="editCourseName" class="form-label">Course Name:</label>
                            <textarea class="form-control" id="editCourseName" name="title" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editCourseDescription" class="form-label">Course Description:</label>
                            <textarea class="form-control" id="editCourseDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#createEditCourseModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var courseId = button.data('course-id');
            var courseTitle = button.data('course-title');
            var courseDescription = button.data('course-description');

            var modal = $(this);
            modal.find('.modal-title').text('Edit Course');
            modal.find('#editCourseName').val(courseTitle);
            modal.find('#editCourseDescription').val(courseDescription);

            var formAction = "{{ url('courses') }}" + '/' + courseId;
            modal.find('#editCourseForm').attr('action', formAction);
        });
    </script>


    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this course?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="#" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(courseId) {
            var formAction = "{{ url('courses') }}" + '/' + courseId;
            $('#deleteForm').attr('action', formAction);
            $('#confirmDeleteModal').modal('show');
        }

        function enrollCourse(courseId) {
            console.log('Enrolling course:', courseId);
            var form = document.createElement('form');
            form.action = `/enrollments/enroll/${courseId}`;
            form.method = 'POST';

            var csrfTokenField = document.createElement('input');
            csrfTokenField.type = 'hidden';
            csrfTokenField.name = '_token';
            csrfTokenField.value = '{{ csrf_token() }}';

            var courseIdField = document.createElement('input');
            courseIdField.type = 'hidden';
            courseIdField.name = 'courseId';
            courseIdField.value = courseId;

            form.appendChild(csrfTokenField);
            form.appendChild(courseIdField);

            document.body.appendChild(form);
            form.submit();
        }

        function unenrollCourse(courseId) {
            console.log('Unenrolling course:', courseId);
            var form = document.createElement('form');
            form.action = `/enrollments/unenroll/${courseId}`;
            form.method = 'POST';

            var csrfTokenField = document.createElement('input');
            csrfTokenField.type = 'hidden';
            csrfTokenField.name = '_token';
            csrfTokenField.value = '{{ csrf_token() }}';

            var courseIdField = document.createElement('input');
            courseIdField.type = 'hidden';
            courseIdField.name = 'courseId'; // Use the correct name expected by your controller
            courseIdField.value = courseId;

            form.appendChild(csrfTokenField);
            form.appendChild(courseIdField);

            document.body.appendChild(form);
            form.submit();
        }

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

    .create-course-btn {
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
        background-color: rgb(173, 164, 164)
    }

    .custom-table th,
    .custom-table td {
        padding: 0.75rem;
        text-align: center;
        border: 1px solid #e2e8f0;
    }

    .no-users-msg {
        text-align: center;
    }

</style>
