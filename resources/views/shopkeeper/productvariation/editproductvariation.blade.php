@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="background-color: #1cf7ff">
                    <div class="card-header" style="background-color: #240808"><span>Product Name : </span></div>
                    <div class="card-body">
                        <table class="table table-bordered" id="dynamicTable">
                            <tr>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th><button type="button" name="add" id="add" class="btn btn-success">Add More <i class="fa fa-plus"></i></button></th>
                            </tr>
                            @foreach( $getProductVariations as $getProductVariation)
                                <tr>
                                    <td><input type="text" name="quantity[]" value = "{{$getProductVariation->quantity}}" class="form-control" /></td>
                                    <td><input type="text" name="price[]" value = "{{$getProductVariation->price}}" class="form-control" /></td>
                                    <td>
                                        <select  id="status" type="text" name="status[]" class="mdb-select md-form form-control">
                                            @if($getProductVariation->status == 'active')
                                                <option selected value="active">Active</option>
                                                <option value="inactive">InActive</option>
                                            @else
                                                    <option value="active">Active</option>
                                                    <option selected value="inactive">InActive</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td><button type="button" name="delete" id="delete" class="btn btn-danger">Remove<i class="fa fa-trash"></i></button></td>
                                </tr>
                            @endforeach
                            <input type="hidden" name="id" id="productId" value="{{$getProductVariation->product_id}}">

                        </table>
                        <button id="updateProductVariations" name="save"  class="btn btn-success">Save</button>
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

           $("#updateProductVariations").on('click', function () {
                let productId = $('#productId').val();
                console.log(productId);
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

                updateProductVariations(productId,quantities,prices,status)
            });
        });

        $(document).on('click', '.remove-tr', function(){
            $(this).parents('tr').remove();
        });
        $(document).on('click', '#delete', function(){
            $(this).parents('tr').remove();
        });

        //Methods
        function updateProductVariations(productId,quantities,prices,status) {
            $.ajax({
                url: '{{route('updateProductVariation')}}',
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

