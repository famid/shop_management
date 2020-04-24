@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color: #1cf7ff">
                    <div class="card-header" style="background-color: #240808"><span>Product Name :{{$product->name}} </span></div>
                    <div class="card-body">
                        <table class="table table-bordered" id="dynamicTable">
                            <input type="hidden" name="id" id="productId" value="{{$product->id}}">
                            <tr>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="quantity[]" placeholder="Enter your quantity" class="form-control" /></td>
                                <td><input type="text" name="price[]" placeholder="Enter your price" class="form-control" /></td>
                                <td>
                                    <select id="status" type="text" name="status[]" class="mdb-select md-form form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">InActive</option>
                                    </select>
                                </td>
                                <td><button type="button" name="add" id="add" class="btn btn-success">Add More <i class="fa fa-plus"></i></button></td>
                            </tr>
                        </table>
                        <button id="submitProductVariations" name="save"  class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card" style="background-color: #f6faff">
                    <div class="card-header" style="background-color: #f2ebff"><span>Product Variation Table </span></div>
                    <div class="card-body">
                        <table id="productVariationsTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>update date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                    <td>2011/04/25</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
        @endsection
        @section('script')
            <script>
                $(document).ready(function () {

                    $("#add").click(function () {
                        $("#dynamicTable").append('<tr>' +
                            '<td><input type="text" name="quantity[]" placeholder="Enter your quantity" class="form-control" /></td>' +
                            '<td><input type="text" name="price[]" placeholder="Enter your price" class="form-control" /></td>' +
                            '<td><select id="status" type="text" name="status[]" class="mdb-select md-form form-control"><option value = "active">Active</option><option value = "inactive">InActive</option></select></td>' +
                            '<td><button type="button" class="btn btn-danger remove-tr">Remove<i class="fa fa-trash"></i></button></td>' +
                            '</tr>');
                    });

                    $("#submitProductVariations").on('click', function () {
                        let productId = $('#productId').val();
                        let quantities = [];
                        $('input[name^="quantity"]').each(function() {
                            quantities.push($(this).val());
                        });
                        let prices = [];
                        $('input[name^="price"]').each(function() {
                            prices.push($(this).val());
                        });
                        let status = [];
                        $('select[name^="status').each(function() {
                            status.push($(this).val());
                        });

                        storeProductVariations(productId,quantities,prices,status);
                    });
                });

                $(document).on('click', '.remove-tr', function(){
                    $(this).parents('tr').remove();
                });
                $(document).ready(function() {
                    $('#productVariationsTable').DataTable();
                } );


                //Methods
                function storeProductVariations(productId,quantities,prices,status) {
                    $.ajax({
                        url: '{{route('storeProductVariations')}}',
                        method: 'POST',
                        data: {
                            '_token': '{{csrf_token()}}',
                            'product_id': productId,
                            'quantities': quantities,
                            'prices' : prices,
                            'status':status
                        }
                    }).done(function (data) {
                        console.log(data);
                        window.location = '{{route('createProduct')}}';
                    }).fail(function (error) {
                        console.log(error);
                    });
                }

            </script>
@endsection
