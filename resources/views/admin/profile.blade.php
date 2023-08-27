@extends('admin.layout.main')
@section('content')
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid">
                    <div class="row" style="min-height:400px">
                        <div class="col-md-4">
                            <h4 style="text-align:center">Admin Details</h4>
                            <div class="form-group">
                                <label for="email">Name</label>
                                <input type="name" class="form-control" name="name" value="{{ $data->name }}">
                            </div><br><br>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $data->email }}">
                            </div><br><br>

                            <div class="form-group">
                                <label for="text">Gender</label>
                                <input type="text" class="form-control" name="password" value="{{ $data->gender }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h4 style="text-align:center"> Admin Information</h4>
                            <div class="form-group">
                                <label for="email">Address</label>
                                <input type="name" class="form-control" name="name" value="{{ $data->address }}">
                            </div><br><br>
                            <div class="form-group">
                                <label for="email">country</label>
                                <input type="name" class="form-control" name="name" value="{{ $data->country_id }}">
                            </div><br><br>
                            <div class="form-group">
                                <label for="email">State</label>
                                <input type="name" class="form-control" name="name" value="{{ $data->state_id }}">
                            </div><br><br>
                            <div class="form-group">
                                <label for="email">City</label>
                                <input type="name" class="form-control" name="name" value="{{ $data->city_id }}">
                            </div><br><br>
                        </div>

                        <div class="col-md-4">
                            
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal">Change Password</button><br><br><br>
                             <center><img src="{{ asset("storage/{$data->image}") }}" class="rounded-circle"
                                    alt="Cinque Terre"></center>

                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- this is model  --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form">
                        @csrf
                        <div class="form-group">
                            <label for="password" class="col-form-label">Old Password</label>
                            <input type="password" class="form-control" id="opassword" name="opassword">
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">New Password</label>
                            <input type="password" class="form-control" id="npassword" name="npassword">
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="cpassword" name="cpassword">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn">Save</button>

                        </div>
                    </form> 

                </div>
            </div>
        </div>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
 
    <script>
        $(document).ready(function() {
                    $('#form').on('submit',function(e) {
                        e.preventDefault();
                            //   alert('jdjdjdj');
                            $("#form").validate({
                                    rules: {
                                        opassword: "required",
                                        npassword: "required",
                                        cpassword: "required",      
                                    },
                                    messages: {  
                                        opassword: "The field required",
                                        npassword: "The field required",
                                        cpassword: "The field required",
                                    },
                                        submitHandler: function() {
                                            $.ajax({
                                                type: "post",
                                                url: "{{ route('changePass') }}",
                                                data: $('#form').serialize(),
                                                success: function(response) {
                                                    if (response == 1) {

                                                        $(".close").click();
                                                        toastr.options.timeOut = 2000;
                                                        toastr.success('Password change Successfully !');
                                                    }
                                                    if (response == 2) {
                                                        toastr.options.timeOut = 2000;
                                                        toastr.error('Both password not matched !');
                                                    }
                                                    if (response == 3) {
                                                        toastr.options.timeOut = 2000;
                                                        toastr.error('Old password not Matched !');
                                                    }

                                                }
                                            });
                                        }
                                    });
                            });
                    });
    </script>
@endsection
