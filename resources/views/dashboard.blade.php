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
                    <h3 class="login-heading mb-4">Welcome to dashboard!</h3>
                    <div class="card">
                        <div class="col-md-12">
                            <div class="col-md-6 float-left d-inline">
                                Welcome {{ ucfirst(Auth()->user()->name) }}
                            </div>
                            <div class="col-md-6 float-right d-inline">
                                <a class="small float-right" href="{{url('logout')}}">Logout</a>
                            </div>
                        </div>
                    </div>
                    {{--Top words are echoed here--}}
                    <div class="col-md-12">
                        Top 10 words of the feed are :
                        @foreach($topWords as $word=>$count)
                            <div class="card d-inline">
                                <strong>{{$word}}</strong> used <strong>{{$count}}</strong> times.
                            </div>
                        @endforeach
                    </div>
                    {{--RSS feed goes here--}}
                    @foreach($feed->entry as $entry)
                        <div class="col-md-12">
                            <div class="col-md-12"><strong class="h3">{{$entry->title}}</strong></div>
                            <div class="col-md-12">
                                <span class="h4">
                                    <em>
                                        <a href="{{$entry->author->uri}}" target="_blank">{{$entry->author->name}}</a> / {{$entry->updated}}
                                    </em>
                                </span>
                            </div>
                            <div class="col-md-12"><p>{{strip_tags($entry->summary)}}</p></div>
                            <div class="col-md-12">
                                <a href="{{$entry->link['href']}}" target="_blank" class="float-right">
                                    Full article
                                </a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
