@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Api Users</div>
                <a href="{{ route('users.api.create') }}">
                    <button class="btn btn-success pull-right">Create new user</button>
                </a>

                <div class="container" style="margin-top: 50px;">
                    <table class="table table-bordered" id="apiUsers">
                        <thead>
                        <th>Client Id</th>
                        <th>User Id</th>
                        <th>Name</th>
                        <th>Secret</th>
                        <th>Actions</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this client ?</p>
                    <p>This action cannot be undone!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" data-id="a" id="deleteUser"
                            onclick="deleteClient($(this))">Delete
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('scripts')
    <script>
        $.ajax({
            url: '/oauth/clients',
            method: 'GET'
        }).done(function (response) {
            var users = [];
            response.forEach(function (val, index) {
                users.push("" +
                    "<tr>" +
                    "<td>" + val.id + "</td>" +
                    "<td>" + val.user_id + "</td>" +
                    "<td>" + val.name + "</td>" +
                    "<td>" + val.secret + "</td>" +
                    "<td class='text-center'>" +
                    "<a href=\"/api_users/edit/" + val.id + "\" style='padding-right: 20px;'><i class=\"fa fa-pencil-square-o\"></i></a>" +
                    "<a href=\"#\" data-id=\"" + val.id + "\" data-toggle=\"modal\" data-target=\"#deleteModal\"><i class=\"fa fa-trash-o\"></i></a>" +
                    "    </a>" +
                    "</td>" +
                    "</tr>");
            });
            $('#apiUsers tbody').html(users);
        });

        $(document).ready(function () {
            $('#deleteModal').on('show.bs.modal', function (e) {
                $('#deleteUser').attr('data-id', $(e.relatedTarget).data('id'));
            });
        });

        function deleteClient(e) {
            $.ajax({
                url: '/oauth/clients/' + e.data('id'),
                method: 'DELETE'
            }).done(function (response) {
                location.reload();
            });
        }
    </script>
@endsection