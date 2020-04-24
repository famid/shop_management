@extends('layouts.layouts_employee_filter')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-10 float-right">
                    <button id="filter" class="btn btn-danger float-right filter-employee "><i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 form-group">
                    <label for="salary"><h4>Salary : </h4></label>
                    <input id="salary" type="number" name="salary" class="form-control custom-input-field" min="1"
                           max="100" value="" placeholder="input your salary">
                </div>
                {{--=================start salary slider--------====--}}
                <div class="col-md-10 salary-range-div">
                    <p>Quantity Range</p>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="salary-slider-range"></div>
                                </div>
                            </div>
                            <div class="row slider-labels">
                                <div class="col-xs-6 caption">
                                    <strong>Min:</strong> <span id="salary-slider-range-value1"></span>
                                </div>
                                <div class="col-xs-6 text-right caption">
                                    <strong>Max:</strong> <span id="salary-slider-range-value2"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form>
                                        <input id="min-salary" type="hidden" name="min-value" value="">
                                        <input id="max-salary" type="hidden" name="max-value" value="">
                                    </form>
                                </div>
                            </div>
                            {{--=============--}}
                        </div>
                    </div>
                </div>
            </div>
            {{--===================start calender--}}
            <div class="row card-body">
                <input id=date-range type="text" name="daterange" value="01/01/2020 - 01/15/2020" />
            </div>
            {{--===================end calender--}}
        </div>
        <div class="col-md-6">
            <div class="card" style="background-color: #936161">
                <!-- Another variation with a button -->
                <div class="input-group">
                    <input id="searchEmployee" type="text" class="form-control" placeholder="Search Employee">
                    <div class="input-group-append">
                        <button id="search" class="btn btn-secondary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card col-md-12">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <table id="searchResultTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Price</th>
                                <th>Started At</th>
                                <th>Ended At</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>

                    </div>
                    <form id="downloadForm" action="{{route('export')}}" method="GET">
                        @csrf
                        <input type="hidden" id="downloadFormData" name="data" value="">
                    </form>
                    <div class="card-footer">
                        <button id="downloadFilterResult" class="btn-danger float-left"><i class="fa fa-download"></i></button>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script>
        $(document).ready(function () {
            let startedAt = null;
            let endedAt = null;
            let employeeName = null;
            let salary = null;
            let minSalaryValue = null;
            let maxSalaryValue = null;
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                startedAt = start.format('YYYY-MM-DD');
                endedAt = end.format('YYYY-MM-DD');
                //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
            $("#filter").on('click', function () {

                salary = $("#salary").val();
                minSalaryValue = $("#salary-slider-range-value1").html();
                maxSalaryValue = $("#salary-slider-range-value2").html();
                employeeName = null;
                getEmployeeFilter(salary,minSalaryValue,maxSalaryValue,startedAt,endedAt,employeeName);
            });
            $("#search").on('click', function () {
                employeeName = $("#searchEmployee").val();
                if(employeeName === ''){
                    alert('Input Filled is Empty');
                }else{
                    startedAt = null;
                    endedAt = null;
                    salary = null;
                    minSalaryValue = null;
                    maxSalaryValue = null;
                    getEmployeeFilter(salary,minSalaryValue,maxSalaryValue,startedAt,endedAt,employeeName);
                }
            });
            $('#salary').on('input change', function () {
                let salary = $("#salary").val();
                if (salary !== '') {
                    $(".salary-range-div").hide();
                } else if (salary === '') {
                    $(".salary-range-div").show();
                }
            });
        });
        function getEmployeeFilter(salary,minSalaryValue,maxSalaryValue,startedAt,endedAt,employeeName) {
            $.ajax({
                url: '{{route('getEmployeeFilterResult')}}',
                method: 'GET',
                data: {
                    'salary': salary,
                    'min_salary': minSalaryValue,
                    'max_salary': maxSalaryValue,
                    'started_at': startedAt,
                    'ended_at': endedAt,
                    'employee_name' : employeeName
                }
            }).done(function (data) {
                console.log(data);
                showEmployeeList(data.data);
                downloadFilterResult(data.data);
            }).fail(function (error) {
                console.log(error);
            });
        }
        function showEmployeeList(data) {
            if (data.length > 0) {
                for (let i = 0; i < data.length; i++) {
                    $("#searchResultTable").append('<tr>' +
                        '<td>' + data[i].employee_name + '</td>' +
                        '<td>' + data[i].employee_salary + '</td>' +
                        '<td>' + data[i].employee_started_at + '</td>' +
                        '<td>' + data[i].employee_ended_at + '</td>' +
                        '</tr>');
                }
            } else {
                $("#searchResultTable").append('<h4>No Employee is found</h4>');
            }
        }
        function downloadFilterResult(data) {
            $('#downloadFilterResult').on('click',function() {
                $("#downloadFormData").val(JSON.stringify(data));
                $("#downloadForm").submit();
            });
        }
    </script>
@endsection
