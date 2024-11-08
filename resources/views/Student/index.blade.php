@extends('layouts.app')

@section('content')
    <!-- add Modal -->
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



    {{-- end addstudent --}}


    {{-- edit part --}}


    <div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">edit & update Student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul id="updateform_errList"></ul>


                    <input type="hidden" id="edit_stud_id">


                    <div class="form-group mb3">
                        <label for="">Name</label>
                        <input type="text" id="edit_name" class="name form-control">
                    </div>

                    <div class="form-group mb3">
                        <label for="">email</label>
                        <input type="text" id="edit_email" class="email form-control">
                    </div>

                    <div class="form-group mb3">
                        <label for="">Phone</label>
                        <input type="text" id="edit_phone" class="phone form-control">
                    </div>

                    <div class="form-group mb3">
                        <label for="">course</label>
                        <input type="text" id="edit_course" class="course form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_student">update</button>
                </div>
            </div>
        </div>
    </div>




    {{-- end of edit  --}}


      {{-- delete part --}}


      <div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                  


                    <input type="hidden" id="delete_stud_id">


            <h4>Do you realy want to delete?</h4>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete_student_btn">Yes Delete</button>
                </div>
            </div>
        </div>
    </div>




    {{-- end of delete  --}}

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

            let phoneNumber = '';
            $('#reload_students').on('click', function() {
                var phoneNumber = $('#phone_number').val();

                if (!phoneNumber) {
                    $('#success_message').html(
                        '<div class="alert alert-warning">Veuillez entrer un numéro de téléphone pour rechercher un étudiant.</div>'
                        );
                    return; // Arrête la fonction si le champ est vide
                }
                console.log("Recherche avec numéro de téléphone : ", phoneNumber);
                fetchstudent(phoneNumber);
            });

            function fetchstudent(phoneNumber = '') {

                $.ajax({
                    type: "GET",
                    url: "/fetch-students",
                    data: {
                        phone: phoneNumber
                    },
                    dataType: "json",
                    success: function(response) {
                        //   console.log(response);
                        //   console.log(response.students);
                        $('tbody').html("");
                        if (response.students && response.students[0]) {
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
                            $('#saveform_errList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            fetchstudent(phoneNumber);
                        }
                    }
                });
            }





$(document).on('click','.delete_student', function (e) {
    e.preventDefault();
    var stud_id=$(this).val();
    phoneNumber = $(this).data('phone');
    // alert(stud_id);
    $('#delete_stud_id').val(stud_id);
    $('#DeleteStudentModal').modal('show');
    
});

$(document).on('click','.delete_student_btn', function (e) {
    e.preventDefault();
$(this).text("Deleting");
    var stud_id=$('#delete_stud_id').val();


    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                

    $.ajax({
        type: "DELETE",
        url: "/delete-student/"+stud_id,
        
        
        success: function (response) {
            
            // console.log(response);
            $('#success_message').addClass('alert alert-success');
            $('#success_message').text(response.message);
            $('#DeleteStudentModal').modal('hide');
            $('.delete_student_btn').text("Yes Delete");

            

            if (phoneNumber) {
    fetchstudent(phoneNumber);
} else {
    $('tbody').html(""); // Vider la table si aucune recherche n'est spécifiée
    $('#success_message').html('<div class="alert alert-success">Étudiant supprimé.</div>');
}
        }
    });
});



            $(document).on('click', '.edit_student', function(e) {
                e.preventDefault();
                var stud_id = $(this).val();
                // console.log(stud_id);
                $('#EditStudentModal').modal('show');

                $.ajax({
                    type: "Get",
                    url: "/edit-student/" + stud_id,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 404) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.mesage);
                        } else {
                            $('#edit_name').val(response.student.name);
                            $('#edit_email').val(response.student.email);
                            $('#edit_phone').val(response.student.phone);
                            $('#edit_course').val(response.student.course);
                            $('#edit_stud_id').val(stud_id);
                        }
                        // console.log(response);


                    }
                });


            });

            $(document).on('click', '.update_student', function(e) {
                e.preventDefault();

                $(this).text('updating');
                var stud_id = $('#edit_stud_id').val();
                var data = {
                    'name': $('#edit_name').val(),
                    'email': $('#edit_email').val(),
                    'phone': $('#edit_phone').val(),
                    'course': $('#edit_course').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                phoneNumber = data.phone;
                console.log("Mise à jour avec numéro de téléphone : ", phoneNumber);

                $.ajax({
                    type: "PUT",
                    url: "/update-student/" + stud_id,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);



                        if (response.status == 400) {
                            // errors
                            $('#updateform_errList').html("");
                            $('#updateform_errList').addClass("alert alert-danger");


                            $.each(response.errors, function(key, err_values) {

                                $('#updateform_errList').append('<li>' + err_values +
                                    '</li>')

                            });
                            $('update_student').text('update');


                        } else if (response.status == 404) {
                            $('#updateform_errList').html("");
                            $('#success_message').addClass('alert alert-success')
                            $('#success_message').text(response.message)
                            $('update_student').text('update');

                        } else {
                            $('#updateform_errList').html("");
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success')
                            $('#success_message').text(response.message)
                            $('#EditStudentModal').modal('hide');
                            $('update_student').text('update');
                            console.log(phoneNumber);
                            fetchstudent(phoneNumber);


                        }
                    }
                });

            });


            // console.log(response.students);








            $(document).on('click', '.add_student', function(e) {
                e.preventDefault();
                // console.log('work');
                var data = {
                    'name': $('.name').val() || null,
                    'email': $('.email').val() || null,
                    'phone': $('.phone').val(),
                    'course': $('.course').val() || null,
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
