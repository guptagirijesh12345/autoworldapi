@extends('admin.layout.main')
@section('content')

	<div class="wrapper">

		<div class="main">
            
			<main class="content">
				<div class="container-fluid p-0">

					<center><h1 class="h3 mb-3"><i>User Details</i></h1></center>
    
                    <div class="container">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered user_datatable">
                                    <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Gender</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                            <th>Soft Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                      $(function () {
                        var table = $('.user_datatable').DataTable({
                            processing: true,
                            serverSide: true,   
                            ajax: "{{ route('user') }}",
                            columns: [
                                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                {data: 'image', name: 'image', orderable: false, searchable: false},
                                {data: 'name', name: 'name'},
                                {data: 'email', name: 'email'},
                                {data: 'mobile', name: 'mobile'},
                                {data: 'gender', name: 'gender'},
                                {data: 'address', name: 'address'},
                                {data: 'action', name: 'action', orderable: false, searchable: false},
                                {data: 'softdelete', name: 'softdelete', orderable: false, searchable: false},

                            ]
                        });
                      });
                    </script>
            

                </div>
            </main>			
		</div>
	</div>
    @endsection
	