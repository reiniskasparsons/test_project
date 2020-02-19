<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--Bootsrap 4 CDN--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script src="{{ mix('/js/app.js') }}"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <h3 class="login-heading mb-4">Please login!</h3>
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{session('success')}}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{session('error')}}
                        </div>
                    @endif
                    {{-- Login form starts--}}
                    <form action="{{url('post-login')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-label-group m-1">
                            <label for="inputEmail">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="some.email@example.com">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="form-label-group m-1">
                            <label for="inputPassword">Password</label>
                            <input type="password" name="password" class="form-control">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2"
                                type="submit">
                            Sign In
                        </button>
                        <div class="text-center">Don't have an account?
                            <a class="small" href="{{url('register')}}">Sign Up</a></div>
                    </form>
                    {{--Login form ends--}}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
