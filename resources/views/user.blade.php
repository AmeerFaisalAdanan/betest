@extends('layouts.app')

@section('head_title', 'List User')

@section('page-title', 'List User')

@section('main-page', 'User')

@section('sub-page', 'List User')

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">No of User: {{$counts}} Records</h4>
    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Users</h4>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="data-table table-bordered table-hover" id="data-table">
                    </table>
                    <script type="text/javascript">
                        $(function () {
                    
                          var table = $('#data-table').DataTable({
                              processing: true,
                            //   serverSide: false,
                              ajax: "{{ route('user.index') }}",
                              columns: [
                                  {title: 'No', data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                  {title: 'Name', data: 'name', name: 'name'},
                                  {title: 'Age', data: 'age', name: 'age'},
                                  {title: 'Gender', data: 'gender', name: 'gender'},
                                  {title: 'Created At', data: 'created_at', name: 'created_at'},
                                  {title: 'Action', data: 'action', name: 'action', orderable: false, searchable: false},
                    
                              ]
                          });
                        });
                      </script>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
