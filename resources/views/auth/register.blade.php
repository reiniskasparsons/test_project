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
    <link rel="stylesheet" type="text/css" href="{{url('style.css')}}">

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <h3 class="login-heading mb-4">Please register!</h3>
                    {{-- Registration form starts--}}
                    <form action="{{url('post-register')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-label-group">
                            <label for="inputName">Name</label>
                            <input type="text" id="inputName" name="name" class="form-control"
                                   placeholder="Full name" autofocus>
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif

                        </div>
                        <div class="form-label-group m-1">
                            <label for="inputEmail">Email address</label>
                            <input type="email" name="email" id="inputEmail" class="form-control"
                                   placeholder="some.email@example.com">
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
                            Sign Up
                        </button>
                        <div class="text-center">Have an account?
                            <a class="small" href="{{url('login')}}">Sign In</a></div>
                    </form>
                    {{--Registration form ends--}}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
