@extends('layouts.login')
@section('title','Login Page')
@section('content')
<div id="login-box" class="login-box visible widget-box no-border">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header blue lighter bigger"><i class="ace-icon fa fa-users green"></i> Please Enter Your Information </h4>
            <div class="space-6"></div>
            <form class="form-horizontal" method="POST" action="{{ route('dbpass.submit.login') }}" id="login-form">
                        {{ csrf_field() }}
                <div class="form-group{{ $errors->has('NamaUser') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">Username</label>

                    <div class="col-md-6">
                        <input id="NamaUser" type="text" class="form-control" name="NamaUser" value="{{ old('NamaUser') }}" required autofocus>

                        @if ($errors->has('NamaUser'))
                            <span class="help-block">
                                <strong>{{ $errors->first('NamaUser') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('Password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Password</label>

                    <div class="col-md-6">
                        <input id="Password" type="Password" class="form-control" name="Password" required>

                        @if ($errors->has('Password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('Password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('Shift') ? ' has-error' : '' }}">
                    <label for="Shift" class="col-md-4 control-label">Shift</label>

                    <div class="col-md-6">
                        <select name="Shift" id="Shift" class="form-control" required>
                            <option value="">-= Shift =-</option>
                            <option value="1"> 1 </option>
                            <option value="2"> 2 </option>
                            <option value="3"> 3 </option>
                        </select>

                        @if ($errors->has('Shift'))
                            <span class="help-block">
                                <strong>{{ $errors->first('Shift') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                    </div>
                </div> -->

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" id="submit-btn" class="btn btn-primary">
                            Login
                        </button>

                        <!-- <a class="btn btn-link" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a> -->
                    </div>
                </div>
            </form>
        </div><!-- /.widget-main -->
    </div><!-- /.login-box -->
</div><!-- /.position-relative -->

@endsection
@section('script')
<script type="text/javascript">
jQuery(function($) {
    $(document).on('click', '.toolbar a[data-target]', function(e) {
    e.preventDefault();
    var target = $(this).data('target');
    $('.widget-box.visible').removeClass('visible');//hide others
    $(target).addClass('visible');//show target
    });
});

$('#NamaUser').keyup(function () {
    $('#NamaUser').val(this.value.toUpperCase());
})
$('#Password').keyup(function () {
    $('#Password').val(this.value.toUpperCase());
});
</script>
@endsection