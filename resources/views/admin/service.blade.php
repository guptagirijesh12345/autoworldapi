@extends('admin.layout.main')
@section('content')
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <center>
                        <h1 class="h3 mb-3"><i>Services</i></h1>
                    </center>
                    <div class="row">
                        <div class="col-md-12 bg-light text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add
                                Service</button>
                        </div><br><br><br><br>
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-left text-center">
                                </div>
                                <div class="pull-right">
                                </div><br>
                            </div>
                        </div>
                      
                        <table class="table table-bordered">
                            <tr>
                                <th>Index</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        
                            @foreach ($data as $key => $value)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>
                                        @if($value->image == "")
                                        <div><img src="{{ asset('dummy/dumm_image.png') }}" style= "vertical-align: middle;width: 75px;height: 75px; border-radius: 50%></div>
                                        @endif
                                        <div><img src="{{ asset("storage/{$value->image}")}}" style= "vertical-align: middle;width: 75px;height: 75px; border-radius: 50%"/></div>
                                    </td>
                                    <td>
                                        @if( $value->status == 1 )
                                        <div><a href="javascript:void(0)" class="btn btn-primary btn-sm">Active</a></div>
                                        @else
                                        <div><a href="javascript:void(0)" class="btn btn-primary btn-sm">NonActive</a></div>
                                        @endif

                                    </td>
                                    <td>{{ $value->service_name }}</td>
                                    <td><a href="" class=" view btn btn-primary btn-sm">View</a></td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="pagination justify-content-center"> {{ $data->links() }}</div>
                    </div>
                </main>
            </div>
    </div>
    @foreach($data as $value)
    @endforeach

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
                        <input type="hidden" class="form-control" id="id" name="id" value="{{ $value->service_category_id}}">
                        <div class="form-group">
                            <label for="text" class="col-form-label">Srvice Category</label>
                            <input type="text" class="form-control" id="service" name="service">
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
                    url: "{{ route('addservice') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response == 1) {
                            $(".close").click();
                            toastr.options.timeOut = 2000;
                            toastr.success(
                                'Service add sucessfully !');
                            location.reload();

                        }
                        if (response == 2) {
                            toastr.options.timeOut = 2000;
                            toastr.error('Service not add!');
                        }
                    }
                });
            });
        });
    </script>
@endsection
