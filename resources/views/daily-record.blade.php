@extends('layouts.app')

@section('head_title', 'Daily Record')

@section('page-title', 'Daily Record')

@section('main-page', 'Daily Record')

@section('sub-page', 'Daily Record')

@section('content')


<div class="card">
    <div class="card-body">
        <h4 class="card-title">Daily Record</h4>
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
                              ajax: "{{ route('daily.index') }}",
                              columns: [
                                  {title: 'No', data: 'DT_RowIndex', name: 'DT_RowIndex'},
                                  {title: 'Date', data: 'date', name: 'date'},
                                  {title: 'Male Count', data: 'male_count', name: 'male_count'},
                                  {title: 'Female Count', data: 'female_count', name: 'female_count'},
                                  {title: 'Average Male Age', data: 'male_avg_age', name: 'male_avg_age'},
                                  {title: 'Average Female Age', data: 'female_avg_age', name: 'female_avg_age'},
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
