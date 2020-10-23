@extends('layouts.school-admin-layout')
@section('page-heading','Teachers / '.$teacher->name)
@section('school-admin-content')
    @include('snippets.teacher-profile',[
        'teacher' => $teacher,
        'edit_route_name' => 'school-admin-edit-teacher',
        'reassign_route_name' => 'school-admin-reassign-teacher-to-school',
        'remove_route_name' => 'school-admin-remove-teacher-from-school',
        'delete_route_name' => 'school-admin-destroy-teacher',
    ])
    @if(!$teacher->has_left)
        <hr class="border border-theme">
        <h3 class="text-break">Subjects Taught By Teacher: {{ $teacher->name }}</h3>
        <h4 class="text-break"><i>Data Shown For: <b><u>{{ getCurrentSchoolSessionName() ?? 'All' }} Session</u></b></i>
        </h4>
        <hr>
        @if($errors->any())
            @push('js')
                <script>
                    $('html, body').animate({
                        scrollTop: $("#add_subject_heading").offset().top
                    }, 2000);
                </script>
            @endpush
        @endif

        <h4 id="add_subject_heading"><b>Add Subject</b></h4>
        <form action="{{ route('school-admin-store-subject-of-teacher',['teacher_id'=>$teacher->id]) }}"
              method="post" id="add_subject_form">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="grade">Grade </label>
                <select name="grade" id="grade" class="form-control @error('grade') is-invalid @enderror" required>
                    <option value=""></option>
                    @foreach ($grades_of_session as $grade)
                        @php
                        $section = "";
                        if(isset($grade->section)){
                            $section = "Section: '$grade->section'";
                        }
                        @endphp
                        <option value="{{ $grade->id }}"
                                data-content="{{ $grade->grade_name }} {{ $section }}
                                    <sub>Session: {{ $grade->SchoolSession->name }}</sub>"></option>
                    @endforeach
                </select>
                @error('grade')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
                @push('js')
                    <script>
                        $('#grade').on('change', function (e) {
                            $.post("{{ route('school-admin-api-subjects-of-grade') }}", //url
                                { grade_id: this.value, }, // data
                                function (result) { // success callback
                                    let subject = $("#subject");
                                    subject.find('option').remove();
                                    //empty selection
                                    let o = new Option();
                                    subject.append(o);
                                    for (let item of Object.values(result)) {
                                        let o = new Option(item.subject_name, item.id);
                                        subject.append(o);
                                    }
                                    subject.selectpicker('refresh');
                                }

                            );
                        });
                        @if($errors->any())
                        document.querySelector('#add_subject_form').scrollIntoView({
                            behavior: 'smooth'
                        });
                        @endif
                    </script>
                @endpush
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <select name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror"
                        required>
                    <option value=""></option>
                </select>
                @error('subject')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
            <div class="form-group">
                @error('grade_subject')
                <span class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
                <br>
                <br>
                <input type="submit" class="btn btn-sm btn-outline-success" value="Add Subject">
            </div>
        </form>
        <br>
        <br>
        <table class="w-100 table-bordered" id="subjects_of_teacher_table">
            <thead>
            <th>SN</th>
            <th>Subject ID</th>
            <th>Subject Name</th>
            <th>Grade</th>
            <th>Section</th>
            <th>School Session</th>
            <th>Grade Info</th>
            <th>Delete</th>
            </thead>
            <tbody>
            @foreach($subjects_of_teacher as $t)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $t->subject_id }}</td>
                    <td>{{ $t->subject_name }}</td>
                    <td>{{ $t->grade }}</td>
                    <td>{{ $t->section }}</td>
                    <td>{{ $t->schoolSession->name }}</td>
                    <td><a href="#" class="btn btn-sm btn-outline-theme">Grade: {{ $t->grade }}
                            @isset($t->section)
                                <br>Section: {{ $t->section }}
                            @endisset</a>
                    </td>
                    <td>
                        <a href="#" class="btn btn-danger btn-sm"
                           id="delete_subject_{{ $t->grade_subject_teacher_id }}">Delete</a>
                        <form action="{{ route('school-admin-destroy-subject-of-teacher',[
                        'teacher_id'=>$teacher->id,
                        'grade_subject_id'=>$t->grade_subject_id ]) }}" method="post"
                              id="delete_subject_{{ $t->grade_subject_teacher_id }}_form">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="grade_subject_id" value="{{ $t->grade_subject_teacher_id }}">
                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                        </form>
                    </td>
                    @push('js')
                        <script>
                            $("#delete_subject_{{ $t->grade_subject_teacher_id }}").on('click', function (e) {
                                e.preventDefault();
                                bootbox.confirm({
                                    message: `Are you sure you want to delete the following subject?<br>
                                        <label class="text-break">Subject : {{ $t->subject_name }}</label><br>
                                        <label class="text-break">Grade : {{ $t->grade }} </label><br>
                                        <label class="text-break">Section : {{ $t->section }} </label><br>`
                                    ,
                                    callback: function (result) {
                                        //if ok pressed result is true
                                        if (result) {
                                            $("#delete_subject_{{ $t->grade_subject_teacher_id }}_form").submit();
                                        }
                                    },
                                    html: true,
                                    container: '#app',

                                });
                            });

                        </script>
                    @endpush
                </tr>
            @endforeach
            </tbody>
        </table>
        @push('css')
            <link rel="stylesheet" href="{{ asset("vendors/DataTables/datatables.css") }}">
        @endpush
        @push('js')
            <script src="{{ asset("vendors/DataTables/datatables.js") }}"></script>
            <script>
                jQuery(function ($) {
                    $('#subjects_of_teacher_table').DataTable({
                        "scrollY": "250px",
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
    @endif
@endsection
