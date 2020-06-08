@extends('layouts.app')
@section('content')
    <div class="container">

                <div class="alert alert-success" id="success_msg" style="display: none;">
                    Updated
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
                        <form method="post" id="contentUpdate" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="exampleInputEmail1">Image</label>
                                <input type="file" id="file" class="form-control" name="image">

                                <small id="image_error" class="form-text text-danger"></small>
                            </div>

                            <input type="text" style="display: none;" class="form-control" value="{{$content -> id}}" name="id">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" value="{{$content->name}}" name="name">
                                <small id="name_error" class="form-text text-danger"></small>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Age</label>
                                <input type="text" class="form-control" value="{{$content->age}}" name="age">
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

                            <button id="update_content" class="btn btn-primary">Update</button>
                        </form>


                    </div>
                </div>
            </div>
    

    @push('scripts')
        <script>

            $(document).on('click', '#update_content', function (e) {
                e.preventDefault();
                $('#image_error').text('');
                $('#name_error').text('');
                $('#age_error').text('');
                $('#gender_id_error').text('');
                var formData = new FormData($('#contentUpdate')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('content.update')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                        if(data.status == true){
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
    @endpush

@stop