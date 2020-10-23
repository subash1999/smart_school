@extends('layouts.school-admin-layout')
@section('page-heading','Students / '.$student->name)
@section('school-admin-content')
    @include('snippets.student-profile',[
        'student' => $student,
        'edit_route_name' => 'school-admin-edit-student',
        'reassign_route_name' => 'school-admin-reassign-student-to-school',
        'remove_route_name' => 'school-admin-remove-student-from-school',
        'delete_route_name' => 'school-admin-destroy-student',
    ])
    <hr class="border-theme">
    <h4 class="text-break" id="add_guardian_heading"><b>Add Guardian Of Student</b></h4>
    @if($errors->any())
        @push('js')
            <script>
                $('html, body').animate({
                    scrollTop: $("#add_guardian_heading").offset().top
                }, 2000);
            </script>
        @endpush
    @endif
    <form action="{{ route('school-admin-store-guardian-of-student',['student_id'=>$student->id]) }}"
          method="post" id="add_guardian_form">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="guardian">Guardian </label>
            <select name="guardian" id="guardian" class="form-control @error('guardian') is-invalid @enderror" required>
                <option value=""></option>
                @foreach (\App\School::findOrFail(getCurrentSchoolId())->Guardians->sortBy('name') as $guardian)
                    <option value="{{ $guardian->id }}"
                            data-content="<div
                        >
                        <img src='{{ getPassportPhotoImageUrl($guardian->passport_photo) }}'
                        loading='lazy'
                        style='height:24px;weight:24px;' class='mr-3'>{{ $guardian->name }}
                                <sub>Guardian ID: {{ $guardian->id }}
                                </sub>
                            </div>"></option>
                @endforeach
            </select>
            @error('guardian')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="relation_to_student">Relation to Student</label>
            <input type="text" class="form-control @error('relation_to_student') is-invalid @enderror"
                   name="relation_to_student"
                   list="relation_to_student">
            <datalist id="relation_to_student">
                @foreach(config('utilities.GuardianRelationToStudent') as $relation)
                    <option value="{{ $relation }}"></option>
                @endforeach
            </datalist>
            @error('relation_to_student')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group">
            @error('guardian_student')
            <span class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <br>
            <br>
            <input type="submit" class="btn btn-sm btn-outline-success" value="Add Guardian">
        </div>
    </form>

    <hr>
    <h3><b>Guardians of Student</b></h3>
    @include('snippets.guardians-table',[
        'guardians' => $guardians,
        'student' => $student,
        'redirect_url' => URL::current(),
        'delete_guardian_of_student_route_name' => 'school-admin-destroy-guardian-of-student',
        'view_route_name' => 'school-admin-show-guardian',
        'edit_route_name' => 'school-admin-edit-guardian',
        'delete_route_name' => 'school-admin-destroy-guardian',
    ])
    <hr>
    <h3><b>Subjects of Student</b></h3>
    <table class="w-100 table-bordered" id="subjects_of_student_table">
        <thead>
        <th>S.N.</th>
        <th>ID</th>
        <th>Subject Name</th>
        <th>Grade</th>
        <th>School Session</th>
        <th>Teacher</th>
        </thead>
    </table>
    @push('css')
        <link rel="stylesheet" href="{{ asset("vendors/DataTables/datatables.css") }}">
    @endpush
    @push('js')
        <script src="{{ asset("vendors/DataTables/datatables.js") }}"></script>
        <script>
            jQuery(function ($) {
                $('#subjects_of_student_table').DataTable({
                    "scrollY": "300px",
                    "scrollX": true,
                    "scrollCollapse": false,
                    stateSave: true,
                    // fixedColumns:   {
                    //     leftColumns: 2,
                    //     rightColumns: 1
                    // },
                }).columns.adjust();
            });
        </script>
    @endpush

@endsection
