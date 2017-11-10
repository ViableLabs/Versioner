@extends('layouts.app')
@section('links')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Versions</div>

                <div class="container" style="margin-top: 50px;">
                    <table class="table table-responsive" id="versionsTable">
                        <thead>
                        <th>Id</th>
                        <th>Repository</th>
                        <th>Version</th>
                        <th>Commit Hash</th>
                        <th>Deployment Date</th>
                        <th>Created At</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
    <script>
        $('#versionsTable').DataTable({
            ajax: '{{ route('versions.ajax.listData') }}',
            serverSide: true,
            columns: [
                {data: 'id'},
                {data: 'repository'},
                {data: 'repository_version'},
                {data: 'commit_hash'},
                {data: 'deployment_date'},
                {data: 'created_at'}
            ]
        });
    </script>
@endsection