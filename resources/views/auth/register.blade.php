<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registration | Naba Al Quran Academy </title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="{{asset('css/admin-style.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="{{ url('/home') }}"><b>Registration </b></a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>

        @include('components.errors')

        <form method="post" action="{{ action('StudentController@register') }}">
            @csrf

            <div class="row">
                <!-- Name Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Date Of Birth Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('date_of_birth', 'Date Of Birth:') !!}
                    {!! Form::date('date_of_birth', null, ['class' => 'form-control','id'=>'date_of_birth']) !!}
                </div>

                @push('scripts')
                    <script type="text/javascript">
                        $('#date_of_birth').datetimepicker({
                            format: 'YYYY-MM-DD HH:mm:ss',
                            useCurrent: false
                        })
                    </script>
                @endpush

                <!-- Email Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Password Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('password', 'Password:') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>

                

                <!-- Father Name Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('father_name', 'Father Name:') !!}
                    {!! Form::text('father_name', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Mother Name Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('mother_name', 'Mother Name:') !!}
                    {!! Form::text('mother_name', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Gender Field -->
                <div class="form-group col-sm-12">
                    {!! Form::label('gender', 'Gender:') !!}
                    <label class="radio-inline">
                        {!! Form::radio('gender', "Male", null) !!} Male
                    </label>

                    <label class="radio-inline">
                        {!! Form::radio('gender', "Female", null) !!} Female
                    </label>

                </div>

                <!-- Country Id Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('country_id', 'Country:') !!}
                    {!! Form::select('country_id', \App\Models\Country::pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                </div>

                <!-- Address Field -->
                <div class="form-group col-sm-12 col-lg-12">
                    {!! Form::label('address', 'Address:') !!}
                    {!! Form::textarea('address', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Student Type Field -->
                <div class="form-group col-sm-12">
                    {!! Form::label('student_type', 'Student Type:') !!}
                    <label class="radio-inline">
                        {!! Form::radio('student_type', "adults", null) !!} Adult
                    </label>

                    <label class="radio-inline">
                        {!! Form::radio('student_type', "kids", null) !!} Kids
                    </label>

                </div>

                <!-- Phone Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('phone', 'Phone:') !!}
                    {!! Form::number('phone', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Home Phone Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('home_phone', 'Home Phone:') !!}
                    {!! Form::number('home_phone', null, ['class' => 'form-control']) !!}
                </div>

                <!-- 'bootstrap / Toggle Switch Sms Notify Field' -->
                <div class="form-group col-sm-6">
                    {!! Form::label('sms_notify', 'Sms Notify:') !!}
                    <label class="checkbox-inline">
                        {!! Form::hidden('sms_notify', 0) !!}
                        {!! Form::checkbox('sms_notify', 1, null,  ['data-toggle' => 'toggle']) !!}
                    </label>
                </div>


                

                <!-- Skype Id Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('skype_id', 'Skype Id:') !!}
                    {!! Form::text('skype_id', null, ['class' => 'form-control']) !!}
                </div>

                <!-- Zoom Id Field -->
                <div class="form-group col-sm-6">
                    {!! Form::label('zoom_id', 'Zoom Id:') !!}
                    {!! Form::text('zoom_id', null, ['class' => 'form-control']) !!}
                </div>

                {{-- <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full Name">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div> --}}

            </div>

            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> I agree to the <a href="#">terms</a>
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="{{ url('/login') }}" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
