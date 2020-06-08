<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Form') }}</title>

    <!-- Scripts -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Form') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container">

                <div class="alert alert-success" id="success_msg" style="display: none;">
                    Saved
                </div>

                <div class="flex-center position-ref full-height">
                    <div class="content">
                        <div class="title m-b-md">
                            <h3>Create New Content</h3>

                        </div>
                        
                        @if(Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        <br>
                        <form method="POST" id="content" action="" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="exampleInputEmail1">Image</label>
                                <input type="file" id="file" class="form-control" name="image">

                                <small id="image_error" class="form-text text-danger"></small>
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" name="name">
                                <small id="name_error" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Age</label>
                                <input type="text" class="form-control" name="age">
                                <small id="age_error" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Gender</label>
                                <select name="gender_id">
                                    @foreach(App\Models\Gender::get() as $gender)
                                        <option value="{{$gender->id}}">{{$gender->name}}</option>
                                    @endforeach
                                </select>
                                <small id="gender_id_error" class="form-text text-danger"></small>
                            </div>

                            <button id="save_content" class="btn btn-primary">Confirm</button>
                        </form>


                    </div>
                </div>
            </div>
    
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    <script>
        $(document).on('click', '#save_content', function (e) {
            e.preventDefault();
            $('#image_error').text('');
            $('#name_error').text('');
            $('#age_error').text('');
            $('#gender_id_error').text('');
            var formData = new FormData($('#content')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('content.store')}}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                }, error: function (reject) {
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        });
    </script>
</body>
</html>