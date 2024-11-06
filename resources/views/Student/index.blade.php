@extends('layouts.app')

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">add Student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul id="saveform_errList"></ul>

                    <div class="form-group mb3">
                        <label for="">Name</label>
                        <input type="text" class="name form-control">
                    </div>

                    <div class="form-group mb3">
                        <label for="">email</label>
                        <input type="text" class="email form-control">
                    </div>

                    <div class="form-group mb3">
                        <label for="">Phone</label>
                        <input type="text" class="phone form-control">
                    </div>

                    <div class="form-group mb3">
                        <label for="">course</label>
                        <input type="text" class="course form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_student">Save</button>
                </div>
            </div>
        </div>
    </div>



    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">

                <div id="success_message"></div>
                <div class="card">
                    <div class="card-header">
                        <h4>Students Data
                            <a href="#" data-bs-toggle="modal" data-bs-target="#AddStudentModal"
                                class="btn btn-primary float-end btn-sm">Add Student</a>
                        </h4>

                        {{-- ------------------------ --}}

                        <div class="input-group mb-3">
                            <input type="text" id="phone_number" class="form-control"
                                placeholder="Entrez un numéro de téléphone">
                            <button id="reload_students" class="btn btn-secondary">Rechercher</button>
                        </div>

                        {{-- ------------------------ --}}

                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-stiped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Course</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





@section('scripts')
    <script>
        $(document).ready(function() {

            $('#reload_students').on('click', function() {
                var phoneNumber = $('#phone_number').val();
                fetchstudent(phoneNumber);
            });

            function fetchstudent(phoneNumber = '') {
        $.ajax({
            type: "GET",
            url: "/fetch-students",
            data: { phone: phoneNumber }, 
            dataType: "json",
            success: function(response) {
                //   console.log(response);
                //   console.log(response.students);
                $('tbody').html("");
                if (response.students.length > 0) {
                    $.each(response.students, function(key, item) {
                        $('tbody').append('<tr>\
                                <td>' + item.id + '</td>\
                                <td>' + item.name + '</td>\
                                <td>' + item.email + '</td>\
                                <td>' + item.phone + '</td>\
                                <td>' + item.course + '</td>\
                                <td><button type="button" value="' + item.id + '" class="edit_student btn btn-primary btn-sm">Edit</button></td>\
                                <td><button type="button" value="' + item.id + '" class="delete_student btn btn-danger btn-sm">Delete</button></td>\
                            </tr>');
                    });
                } else {
                    $('tbody').append('<tr><td colspan="7" class="text-center">Aucun étudiant trouvé pour ce numéro de téléphone.</td></tr>');
                }
            }
        });
    }





  // console.log(response.students);






            

            $(document).on('click', '.add_student', function(e) {
                e.preventDefault();
                // console.log('work');
                var data = {
                    'name': $('.name').val()|| null,
                    'email': $('.email').val()||null,
                    'phone': $('.phone').val(),
                    'course': $('.course').val()||null,
                }
                // console.log(data);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });



                $.ajax({
                    type: "POST",
                    url: "/students",
                    data: data,
                    dataType: "json",
                    success: function(response) {

                        // console.log(response.errors.name);
                        if (response.status == 400) {

                            $('#saveform_errList').html("");
                            $('#saveform_errList').addClass("alert alert-danger");


                            $.each(response.errors, function(key, err_values) {

                                $('#saveform_errList').append('<li>' + err_values +
                                    '</li>')

                            });
                        } else {
                            $('#saveform_errList').html("");
                            $('#success_message').addClass('alert alert-success')
                            $('#success_message').text(response.message)
                            $('#AddStudentModal').modal('hide');
                            $('#AddStudentModal').find('input').val("");
                            
                        }


                    }
                });









            });

        });
    </script>
@endsection
