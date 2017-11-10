@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Create Api User</div>

                <div class="container" style="margin-top: 50px;">
                    <div class="col-md-12">
                        <div class="row">
                            {!! Form::open(['id' => 'createApiUser', 'class' => 'pull-left', 'style' => 'width: 100%']) !!}
                            <div class="col-md-6 panel">
                                <div class="row">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', $user->name ?? null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            {!! Form::hidden('redirect', $user->redirect ?? '/', ['id' => 'redirect']) !!}
                            {!! Form::hidden('id', $user->id ?? null, ['id' => 'id_field']) !!}
                            <div class="col-md-12 panel">
                                <div class="row">
                                    {!! Form::submit('Save', ['class' => 'btn btn-success pull-left']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#createApiUser').submit(function (e) {
            e.preventDefault();
            if ($('#id_field').val() == '') {
                $.ajax({
                    url: '/oauth/clients',
                    method: 'POST',
                    data: {
                        name: $('#name').val(),
                        redirect: '{{ url('/') }}'
                    }
                }).done(function (response) {
                    window.location.replace("{{url('/api_users')}}");
                });
            } else {
                $.ajax({
                    url: '/oauth/clients/' + $('#id_field').val(),
                    method: 'PUT',
                    data: {
                        name: $('#name').val(),
                        redirect: '{{ url('/') }}'
                    }
                }).done(function (response) {
                    window.location.replace("{{url('/api_users')}}");
                });
            }

        });
    </script>
@endsection