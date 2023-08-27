@extends('admin.layout.main')
@section('content')
    <div class="wrapper">
        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <center>
                        <h1 class="h3 mb-3"><i>Business Details</i></h1>
                    </center><br><br>
                    <div class="container">
                        <div class="row">
                            <div class="row input-daterange">
                                <div class="col-md-4">
                                    Start Date<input type="date" name="sdate" id="sdate" class="form-control"
                                        placeholder="Start Date" />
                                </div>
                                <div class="col-md-4">
                                    End Date <input type="date" name="edate" id="edate" class="form-control"
                                        placeholder="End Date" />
                                </div>
                                <div class="col-md-2">
                                    <button type="button" name="filter" id="filter"class="btn btn-primary">Filter</button>
                                    <button type="button" name="refresh" id="refresh" class="btn btn-primary">Refresh</button>

                                </div>
                            </div>
                            <br><br><br>
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
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            filter();
                            function filter(sdate = '', edate = '') {

                                var table = $('.user_datatable').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    // ajax: "{{ route('business') }}",
                                    ajax: {
                                        url: "{{ route('business') }}",
                                        data: {
                                            sdate: sdate,
                                            edate: edate
                                        }
                                    },
                                    columns: [{
                                            data: 'DT_RowIndex',
                                            name: 'DT_RowIndex'
                                        },
                                        {
                                            data: 'image',
                                            name: 'image',
                                            orderable: false,
                                            searchable: false
                                        },
                                        {
                                            data: 'name',
                                            name: 'name'
                                        },
                                        {
                                            data: 'email',
                                            name: 'email'
                                        },
                                        {
                                            data: 'mobile',
                                            name: 'mobile'
                                        },
                                        {
                                            data: 'gender',
                                            name: 'gender'
                                        },
                                        {
                                            data: 'address',
                                            name: 'address'
                                        },
                                        {
                                            data: 'action',
                                            name: 'action',
                                            orderable: false,
                                            searchable: false
                                        },

                                    ]
                                });
                            }
                            $('#filter').click(function() {
                                var sdate = $('#sdate').val();
                                var edate = $('#edate').val();
                                // alert(sdate);

                                if (sdate != '' && edate != '') {
                                    $('.user_datatable').DataTable().destroy();
                                    filter(sdate, edate);
                                } else {
                                    alert('Both Date is required');
                                }
                            });

                            $('#refresh').click(function() {
                                $('#sdate').val('');
                                $('#edate').val('');
                                $('.user_datatable').DataTable().destroy();
                                filter();
                            });

                        });
                    </script>
                </div>
            </main>
        </div>
    </div>
@endsection
