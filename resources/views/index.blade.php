@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-md-10 mx-auto">
            <br><br>
            <button class="btn btn-primary pull-right mb-2" id="create_user">Create
                User</button>
            <span id="message"></span>
            <table class="table table-striped" id="user_table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Experience</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('include.modal')
@endsection
@section('script')
    <script>
        $(function() {
            $('#user_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user.data.ajax') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'avatar',
                        name: 'avatar',
                        searchable: true
                    },
                    {
                        data: 'name',
                        name: 'name',
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        searchable: true
                    },
                    {
                        data: 'experience',
                        name: 'experience',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            $('#create_user').on('click', function() {
                $('.modal-title').text("Add New User");
                $('#action_button').val("Add");
                $('#action').val("Add");
                $('#userModal').modal('show');
            });
            $('#form_submit').on('submit', function(e) {
                e.preventDefault();
                if ($('#action').val() == 'Add') {
                    $.ajax({
                        url: "{{ route('user.store') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == true) {
                                const html = '<div class="alert alert-success">' + response
                                    .message + '</div>';
                                $('#message').html(html);
                                $('#form_submit')[0].reset();
                                $('#user_table').DataTable().ajax.reload();
                                $('#userModal').modal('hide');
                            }
                        },
                        error: function(error) {
                            if (error.responseJSON.status == false) {
                                $.each(error.responseJSON.error_message, function(key, val) {
                                    $('#' + key + '_error').html(val);
                                });
                            }
                        }
                    });
                }
            });
            $('#still_working').on('click', function() {
                const check = $(this).is(":checked");
                if (check) {
                    $('#dol').val('');
                }
            });
            $('#dol').on('change', function() {
                $("#still_working").prop("checked", false);
            });

            // Delete Modal
            var user_id;
            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
                
            });

            $('#ok_button').click(function() {
                $.ajax({
                    url: "delete/user/" + user_id,
                    beforeSend: function() {
                        $('#ok_button').text('Deleting...');
                        $('#ok_button').prop('disabled', 'disabled');
                    },
                    success: function(data) {
                        if(data.status == true) {
                            setTimeout(function() {
                                $('#confirmModal').modal('hide');
                                $('#user_table').DataTable().ajax.reload();
                                $('#ok_button').text('Delete');
                            }, 1000);
                        }else {
                            alert(data.message);
                        }
                    }
                })
            });
        });

    </script>
@endsection
