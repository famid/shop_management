@extends('layouts.appfilter')
@section('content')
    <div class="row">
        <div class="col-md-5" style="background-color: rgba(252,252,252,0.83)">
            <div class="row">
                <div class="col-md-12 float-right">
                    <button id="filter" class="btn btn-danger float-right filter-product "><i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 form-group">
                    <label for="price"><h4>Price : </h4></label>
                    <input id="price" type="number" name="price" class="form-control custom-input-field" min="1"
                           max="10000" value="" placeholder="input your price">
                </div>
                <div class="col-md-10 price-range-div">
                    <p>Price Range</p>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="price-slider-range"></div>
                                </div>
                            </div>
                            <div class="row slider-labels">
                                <div class="col-xs-6 caption">
                                    <strong>Min:</strong> <span id="price-slider-range-value1"></span>
                                </div>
                                <div class="col-xs-6 text-right caption">
                                    <strong>Max:</strong> <span id="price-slider-range-value2"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form>
                                        <input type="hidden" id="min-price"  name="min-value" value="">
                                        <input type="hidden" id="max-price"  name="max-value" value="">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 form-group">
                    <label for="quantity"><h4>Quantity : </h4></label>
                    <input id="quantity" type="number" name="quantity" class="form-control custom-input-field" min="1"
                           max="100" value="" placeholder="input your quantity">
                </div>
                {{--=================start quantity slider--------====--}}
                <div class="col-md-10 quantity-range-div">
                    <p>Quantity Range</p>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="quantity-slider-range"></div>
                                </div>
                            </div>
                            <div class="row slider-labels">
                                <div class="col-xs-6 caption">
                                    <strong>Min:</strong> <span id="quantity-slider-range-value1"></span>
                                </div>
                                <div class="col-xs-6 text-right caption">
                                    <strong>Max:</strong> <span id="quantity-slider-range-value2"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form>
                                        <input id="min-quantity" type="hidden" name="min-value" value="">
                                        <input id="max-quantity" type="hidden" name="max-value" value="">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="background-color: rgba(232,226,226,0.29)">
                <div class="card-header" style="background-color: #fff9f2"><span>Select Your Category</span></div>
                <div class="card-body-category">
                    @foreach($categories as $category)
                        <input class="category-checkbox" type="checkbox" id="categoryNameList{{$category->id}}"
                               name="category_name[]"
                               value="{{$category->id}}">
                        <label for="categoryName">{{$category->name}}</label><br>
                    @endforeach
                </div>
                <div class="card-header" style="background-color: #fff9f2"><h4>Select Your SubCategory</h4></div>
                <div class="card-body-subCategory">

                </div>
            </div>
        </div>
        {{--==============================end of left side=================--}}
        {{--==============================start of right side=================--}}
        <div class="col-md-7" style="background-color: #c7c2c2">
            <div class="card" style="background-color: #936161">
                <!-- Another variation with a button -->
                <div class="input-group">
                    <input id="searchProduct" type="text" class="form-control" placeholder="Search product">
                    <div class="input-group-append">
                        <button id="search" class="btn btn-secondary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!----------------------- end --------------------------->
            <div class="row">
                <div class="card col-md-12">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <table id="searchResultTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
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
            let price =null;
            let quantity =null;
            let minQuantityValue = null;
            let maxQuantityValue = null;
            let minPriceValue =null;
            let maxPriceValue = null;
            let productName = null;

/*=======================Events============================================*/
            $("#filter").on('click', function () {
                let categories = [];
                let subcategories = [];
                $.each($("input[name^='category_name']:checked"), function () {
                    categories.push($(this).val());
                });
                if (categories.length === 0) {
                    categories = null;
                }
                $.each($("input[name^='subcategory_name']:checked"), function () {
                    subcategories.push($(this).val());
                });
                if (subcategories.length === 0) {
                    subcategories = null;
                }
                price = $("#price").val();
                quantity = $("#quantity").val();
                minQuantityValue = $("#quantity-slider-range-value1").html();
                maxQuantityValue = $("#quantity-slider-range-value2").html();
                minPriceValue = $("#price-slider-range-value1").html();
                maxPriceValue = $("#price-slider-range-value2").html();

                getFilterResult(categories, subcategories, price, quantity,minQuantityValue,maxQuantityValue,minPriceValue,maxPriceValue,productName);
            });

            $("#search").on('click', function () {
                productName = $("#searchProduct").val();
                if(productName === ''){
                    alert('Input Filled is Empty');
                }else{
                    categories = null;
                    subcategories = null;
                    price =null;
                    quantity =null;
                    minQuantityValue = null;
                    maxQuantityValue = null;
                    minPriceValue =null;
                    maxPriceValue = null;
                    getFilterResult(categories, subcategories, price, quantity,minQuantityValue,maxQuantityValue,minPriceValue,maxPriceValue,productName);
                }
            });

            $(".category-checkbox").on('click', function () {
                let checkboxInputFiledId = '#categoryNameList' + $(this).val();
                let categoryId = '';
                let checked = false;
                if ($(checkboxInputFiledId).is(":checked")) {
                    categoryId = $(this).val();
                    checked = true;
                    getSpecificSubCategory(categoryId, checked);
                } else {
                    categoryId = $(this).val();
                    getSpecificSubCategory(categoryId, checked);
                }
            });

            $('#price').on('input change', function () {
                let price = $("#price").val();
                if (price !== '') {
                    $(".price-range-div").hide();
                } else if (price === '') {
                    $(".price-range-div").show();
                }
            });

            $('#quantity').on('input change', function () {
                let quantity = $("#quantity").val();
                if (quantity !== '') {
                    $(".quantity-range-div").hide();
                } else if (quantity === '') {
                    $(".quantity-range-div").show();
                }
            });
        });
        /*=======================END Events============================================*/
        /*=======================Start Methods============================================*/
        function getSpecificSubCategory(categoryId, checked) {
            $.ajax({
                url: '{{route('specificSubCategory')}}',
                method: 'GET',
                data: {
                    'id': categoryId
                }
            }).done(function (data) {
                console.log(data);
                if (checked) {
                    appendSubCategory(data.getSubCategory);
                } else {
                    removeSubCategory(data.getSubCategory);
                }
            }).fail(function (error) {
                console.log(error);
            });
        }

        function getFilterResult(categories, subcategories, price, quantity,minQuantityValue,maxQuantityValue,minPriceValue,maxPriceValue,productName) {
            $.ajax({
                url: '{{route('getFilterResult')}}',
                method: 'GET',
                data: {
                    'category_id': categories,
                    'subcategory_id': subcategories,
                    'price': price,
                    'quantity': quantity,
                    'quantity_min':minQuantityValue,
                    'quantity_max': maxQuantityValue,
                    'price_min':minPriceValue,
                    'price_max':maxPriceValue,
                    'product_name': productName
                }
            }).done(function (data) {
                console.log(data);
                showFilterResult(data.data);
                downloadFilterResult(data.data);
            }).fail(function (error) {
                console.log(error);
            });
        }

        function appendSubCategory(getSubCategory) {
            for (let i = 0; i < getSubCategory.length; i++) {
                $('.card-body-subCategory').append('<div id="subCategoryNameList' + getSubCategory[i].id + '">' +
                    '<input type="checkbox" name="subcategory_name[]" value="' + getSubCategory[i].id + '">' +
                    '<label for="subCategory">' + getSubCategory[i].name + '</label>' +
                    '<div>');
            }
        }

        function removeSubCategory(getSubCategory) {
            for (let i = 0; i < getSubCategory.length; i++) {
                /*create subCategory Id*/
                let checkboxInputFiledId = '#subCategoryNameList' + getSubCategory[i].id;

                $(checkboxInputFiledId).remove();
            }
        }

        function downloadFilterResult(data) {
            $('#downloadFilterResult').on('click',function() {
                $("#downloadFormData").val(JSON.stringify(data));
                $("#downloadForm").submit();
            });
        }

        function showFilterResult(data) {
            if (data.length > 0) {
                for (let i = 0; i < data.length; i++) {
                    $("#searchResultTable").append('<tr>' +
                        '<td>' + data[i].product_name + '</td>' +
                        '<td>' + data[i].product_price + '</td>' +
                        '<td>' + data[i].product_quantity + '</td>' +
                        '</tr>');
                }
            } else {
                $("#searchResultTable").append('<h4>No Product is found</h4>');
            }
        }
    </script>
@endsection
