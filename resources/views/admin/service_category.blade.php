
@extends('admin.layout.main')
@section('content')
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <center>
                        <h1 class="h3 mb-3"><i>Service Category</i></h1>
                    </center>
                    <div class="row">
                        <div class="col-md-12 bg-light text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add
                                Category</button>
                        </div><br><br><br><br>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered user_datatable">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Service Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $(function() {
                                var table = $('.user_datatable').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    ajax: "{{ route('service_category') }}",
                                    columns: [{
                                            data: 'id',
                                            name: 'id'
                                        },
                                        {
                                            data: 'image',
                                            name: 'image',
                                            orderable: false,
                                            searchable: false
                                        },
                                        {
                                            data: 'status',
                                            name: 'status',
                                            orderable: false,
                                            searchable: false
                                        },
                                        {
                                            data: 'name',
                                            name: 'name'
                                        },
                                        {
                                            data: 'action',
                                            name: 'action',
                                            orderable: false,
                                            searchable: false
                                        },
                                    ]
                                });
                            });
                        </script>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Service Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="text" class="col-form-label">Add Srvice Category</label>
                            <input type="text" class="form-control" id="category" name="category">
                        </div>
                        <div class="form-group">
                            <label for="file" class="col-form-label">Image</label>
                            <input type="file" class="form-control" id="file" name="file">
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
    <script>
        $(document).ready(function() {
            $('#form').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);
                $.ajax({
                    type: "post",
                    url: "{{ route('addservice_category') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response == 1) {
                            $(".close").click();
                            toastr.options.timeOut = 2000;
                            toastr.success(
                                'Service category add sucessfully !');
                            location.reload();

                        }
                        if (response == 2) {
                            toastr.options.timeOut = 2000;
                            toastr.error('Service category not add!');
                        }
                    }
                });
            });
        });
    </script>
@endsection
