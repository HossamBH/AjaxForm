@extends('layouts.app')
@inject(genders,App\Models\Gender)
@section('content')
 
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Content
        <small>list</small>
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol> -->
    </section>

    <div class="alert alert-success" id="success_msg" style="display: none;">
        Deleted
    </div>

    <!-- Main content -->
    <section class="content">
      
      <div class="form-group">
          <input type="text" class="form-controller" id="search" name="name"></input>
      </div>

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Show Content</h3>
        </div>
        <div class="box-body">

  
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Image</th>
                  <th>Gender</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
                </thead>

                <tbody id="ss">
                  
                </tbody>
              </table>
            </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->

    @push('scripts')
    <script>
        $(document).ready(function () {

            fetch_data();

            function fetch_data(query = '')
            {
                $.ajax({
                  method : 'get',
                  url : "{{route('content.search')}}",
                  data:{query:query},
                  dataType:'json',
                  success:function(data){
                  $('tbody').html(data.table_data);
                  }
                })
            }

            $(document).on('keyup', '#search', function (e) {

              var query = $(this).val();
              fetch_data(query);
            });
      });

      $(document).on('click', '.delete_btn', function (e) {
            e.preventDefault();
              var row_id =  $(this).attr('row_id');
            $.ajax({
                type: 'post',
                 url: "{{route('content.delete')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'id' : row_id
                },
                success: function (data) {
                    if(data.status == true){
                        $('#success_msg').show();
                    }
                    $('.tr'+data.id).remove();
                }, error: function (reject) {
                }
            });
        });
    </script>
      <script>
        
    </script>

    <script type="text/javascript">
      
    </script>

    @endpush

@endsection
