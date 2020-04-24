@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color: #000000">
                    <div class="card-header"style="background-color: #fff9f2"> <span>Employee Recruitment</span></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="custom-input-label" for="employeeName">Employee Name:</label>
                            <input type="text" id="employeeName" class="form-control custom-input-field" name="name" value="">
                        </div>
                        <div class="form-group">
                            <label class="custom-input-label" for="salary">Salary:</label>
                            <input type="number" id="salary" class="form-control custom-input-field" name="salary" value="">
                        </div>
                        <div class="form-group">
                            <label class="custom-input-label" for="stillWorking">Working Status:</label>
                            <select name="still_working" id="stillWorking" class="form-control custom-input-field">
                                <option value="0">InActive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="custom-input-label" for="startedAt">Started At:</label>
                            <input type="date" id="startedAt" class="form-control custom-input-field" name="started_at" value="">
                        </div>
                        <div class="form-group">
                            <label class="custom-input-label" for="endedAt">Ended At:</label>
                            <input type="date" id="endedAt" class="form-control custom-input-field" name="ended_at" value="">
                        </div>

                        <div class="form-group pt-4">
                            <button id="submit" class="btn btn-outline-success">Save</button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Employee List</div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Salary</th>
                                        <th>Working Status</th>
                                        <th>Started At</th>
                                        <th>Ended At</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="employeeList">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                </div>
                <div class="modal-body" style="background-color: #000000">
                    {{--------------------------edit input field-----------------------------------}}
                    <input type="hidden" id = "editEmployeeId" name="id" class="form-control custom-input-field">
                    <div class="form-group">
                        <label class="custom-input-label" for="editEmployeeName">Employee Name:</label>
                        <input type="text" id="editEmployeeName" class="form-control custom-input-field" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label class="custom-input-label" for="editSalary">Salary:</label>
                        <input type="number" id="editSalary" class="form-control custom-input-field" name="salary" value="">
                    </div>
                    <div class="form-group">
                        <label class="custom-input-label" for="editStillWorking">Working Status:</label>
                        <select name="still_working" id="editStillWorking" class="form-control custom-input-field">
                            <option value="0">InActive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="custom-input-label" for="editStartedAt">Started At:</label>
                        <input type="date" id="editStartedAt" class="form-control custom-input-field" name="started_at" value="">
                    </div>
                    <div class="form-group">
                        <label class="custom-input-label" for="editEndedAt">Ended At:</label>
                        <input type="date" id="editEndedAt" class="form-control custom-input-field" name="ended_at" value="">
                    </div>
                    {{-------------------------------------------------------------------------------------}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update-employee" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            getAllEmployee();
    /*==========================Events=============================================*/
            $("#submit").on('click', function(){
                let employeeName = $("#employeeName").val();
                let salary = $("#salary").val();
                let stillWorking = $("#stillWorking").val();
                let startedAt = $("#startedAt").val();
                let endedAt = $("#endedAt").val();

                saveEmployee(employeeName, salary, stillWorking, startedAt, endedAt);
            });
            $("tbody").on('click','.delete-employee',function () {
                let employeeId = $(this).data('id');
                deleteEmployee(employeeId);
            });

            $("tbody").on('click','.edit-employee',function () {
                let employeeId = $(this).data('id');
                $("#editEmployeeId").val(employeeId);
                getModalData(employeeId);
            });

            $('.update-employee').click(function () {
                console.log('hollll');
                let employeeId = $("#editEmployeeId").val();
                let employeeName = $("#editEmployeeName").val();
                let salary = $("#editSalary").val();
                let stillWorking = $("#editStillWorking").val();
                let startedAt = $("#editStartedAt").val();
                let endedAt = $("#editEndedAt").val();
                updateEmployee(employeeId,employeeName, salary, stillWorking, startedAt, endedAt);
            });
        });
    /*===============================Methods==========================================*/
        function getModalData(employeeId){
            $.ajax({
                url: '{{route('getModalData')}}',
                method: 'GET',
                data:{
                    'id' : employeeId
                }
            }).done(function (data) {
                console.log(data);
                injectModalValue(data.getModalData);
            }).fail(function (error) {
                console.log(error);
            });
        }
        function injectModalValue(getModalData) {
            $("#editEmployeeName").val(getModalData.name);
            $("#editSalary").val(getModalData.salary);
            $("#editStillWorking").val(getModalData.still_working);
            $("#editStartedAt").val(getModalData.started_at);
            $("#editEndedAt").val(getModalData.ended_at);
        }
        function saveEmployee(employeeName, salary, stillWorking, startedAt, endedAt) {
            $.ajax({
                url: '{{route('storeEmployee')}}',
                method: 'POST',
                data:{
                    '_token' : '{{csrf_token()}}',
                    'name': employeeName,
                    'salary' : salary,
                    'still_working' : stillWorking,
                    'started_at' : startedAt,
                    'ended_at' : endedAt
                }
            }).done(function (data) {
                console.log(data);
                getAllEmployee();
                resetInputFields();
            }).fail(function (error) {
                console.log(error);
            });
        }

        function getAllEmployee() {
            $.ajax({
                url:'{{route('getEmployeeList')}}',
                method: 'GET',
            }).done(function (data) {
                console.log(data);
                injectDynamicDom(data.allEmployee);
            }).fail(function (error) {
                console.log(error);
            });
        }

        function deleteEmployee(employeeId) {
            $.ajax({
                url:'{{route('deleteEmployee')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    'id': employeeId
                }
            }).done(function (data) {
                console.log(data);
                getAllEmployee();
            }).fail(function (error) {
                console.log(error);
            });
        }

        function updateEmployee(employeeId,employeeName, salary, stillWorking, startedAt, endedAt) {
            $.ajax({
                url: '{{route('updateEmployee')}}',
                method: 'POST',
                data:{
                    '_token' : '{{csrf_token()}}',
                    'id' : employeeId,
                    'shop_id' : '{{auth()->user()->id}}',
                    'name': employeeName,
                    'salary' : salary,
                    'still_working' : stillWorking,
                    'started_at' : startedAt,
                    'ended_at' : endedAt
                }
            }).done(function (data) {
                console.log(data);
                getAllEmployee();
                resetInputFields();
            }).fail(function (error) {
                console.log(error);
            });
        }

        function injectDynamicDom (allEmployee) {
            let html = '';
            for(let i=0; i< allEmployee.length;i++) {
                html +='<tr>' +
                    '<td>'+allEmployee[i].name+'</td>'+
                    '<td>'+allEmployee[i].salary+'</td>'+
                    '<td>'+allEmployee[i].still_working+'</td>'+
                    '<td>'+allEmployee[i].started_at+'</td>'+
                    '<td>'+allEmployee[i].ended_at+'</td>'+
                    '<td><button type="button" data-id="'+allEmployee[i].id+'" data-toggle="modal" data-target="#editModal" class="btn btn-outline-success float-right edit-employee"><i class="fa fa-plus"></i></button></td>'+
                    '<td><button type="button" data-id="'+allEmployee[i].id+'" class="btn btn-outline-danger float-right delete-employee"> <i class="fa fa-plus"></i></button></td>'+
                    '</tr>'+
                    '<hr>';
            }
            $("tbody").html(html);
        }

        function resetInputFields() {
            $("#categoryName").val('');
            $("#employeeName").val('');
            $("#salary").val('');
            $("#stillWorking").val('');
            $("#startedAt").val('');
            $("#endedAt").val('');
        }
    </script>
@endsection

