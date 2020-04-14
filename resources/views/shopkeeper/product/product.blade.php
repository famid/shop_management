@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="background-color: #191d1f">
                    <div class="card-header" style="background-color: #000000"><span>Create Your Products</span></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="custom-input-label" for="productName">Product Name:</label>
                            <input name="name" type="text" id="productName" class="form-control custom-input-field "
                                   value="">
                        </div>
                        <div class="form-group">
                            <label class="custom-input-label" for="categoryNameList">select your Category:</label>
                            <select id="categoryNameList" class="mdb-select md-form form-control">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group sub-category-div">
                            <label class="custom-input-label" for="subCategoryNameList">select your SubCategory:</label>
                            <select id="subCategoryNameList" class="mdb-select md-form form-control">

                            </select>
                        </div>
                        <div class="form-group pt-4">
                            <button id="save-product-button" type="submit" class="btn btn-outline-success ">Save
                            </button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Product
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span>Product Name</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Edit</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Delete</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Add Product Variation</span>
                                    </div>
                                    <div class="col-md-2">
                                        <span>Edit Product Variation</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ol id="productList">

                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Your Product </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editProductName">Product Name </label>
                            <input type="hidden" name="id" id="editProductId" value="">
                            <input type="text" name="name" value="" class="form-control" id="editProductName">
                        </div>
                        <div class="form-group">
                            <label class="custom-input-label" for="updateCategoryNameList">select your Category:</label>
                            <select id="updateCategoryNameList" class="mdb-select md-form form-control">
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="custom-input-label" for="updateSubCategoryNameList">select your
                                SubCategory:</label>
                            <select id="updateSubCategoryNameList" class="mdb-select md-form form-control">

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary update-product" data-dismiss="modal">Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

        $(document).ready(function () {
            $(".sub-category-div").hide();
            getAllProduct();
            //Events
            $("#categoryNameList").on('click', function () {
                let categoryId = $("#categoryNameList").val();
                if (categoryId == null) {
                    $("#save-product-button").alert('click', 'select your Category first');
                } else {
                    let checkCreateOrUpdateSubCategory = "createSubCategory";
                    specificSubCategory(categoryId, checkCreateOrUpdateSubCategory);
                    $(".sub-category-div").show();
                }
            });

            $("#save-product-button").on('click', function () {
                let productName = $("#productName").val();
                let categoryId = $('#categoryNameList').val();
                let subCategoryId = $("#subCategoryNameList").val();
                saveProduct(productName, categoryId, subCategoryId);
            });

            $("#productList").on('click', '.delete-product', function () {
                let productId = $(this).data('id');
                deleteProduct(productId);
            });

            $("#productList").on('click', '.edit-product', function () {
                let productId = $(this).data('id');
                let productName = $(this).data('name');
                $("#editProductId").val(productId);
                $("#editProductName").val(productName);
                getEditModalData(productId);
            });

            $("#updateCategoryNameList").on('click', function () {
                let categoryId = $("#updateCategoryNameList").val();
                let checkCreateOrUpdateSubCategory = "updateSubCategory";
                specificSubCategory(categoryId, checkCreateOrUpdateSubCategory);
            });

            $('.update-product').click(function () {
                let productId = $("#editProductId").val();
                let productName = $("#editProductName").val();
                let categoryId = $("#updateCategoryNameList").val();
                let subCategoryId = $("#updateSubCategoryNameList").val();
                updateProduct(productId, productName, categoryId, subCategoryId);
            });

        });

        //Methods

        function saveProduct(productName, categoryId, subCategoryId) {
            $.ajax({
                url: '{{route('storeProduct')}}',
                method: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'name': productName,
                    'shop_id': '{{auth()->user()->shop->id}}',
                    'category_id': categoryId,
                    'subcategory_id': subCategoryId
                }
            }).done(function (data) {
                console.log(data);
                getAllProduct();
                resetInputFields();
            }).fail(function (error) {
                console.log(error);
            });
        }

        function updateProduct(productId, productName, categoryId, subCategoryId) {
            $.ajax({
                url: '{{route('updateProduct')}}',
                method: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': productId,
                    'shop_id': '{{auth()->user()->shop->id}}',
                    'name': productName,
                    'category_id': categoryId,
                    'subcategory_id': subCategoryId
                }
            }).done(function (data) {
                console.log(data);
                getAllProduct();
                resetInputFields();
            }).fail(function (error) {
                console.log(error);
            });
        }

        function deleteProduct(productId) {
            $.ajax({
                url: '{{route('deleteProduct')}}',
                method: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': productId
                }
            }).done(function (data) {
                console.log(data);
                getAllProduct();
            }).fail(function (error) {
                console.log(error);
            });
        }

        function getAllProduct() {
            $.ajax({
                url: '{{route('getProductList')}}',
                method: 'GET',
            }).done(function (data) {
                console.log(data);
                injectDynamicDom(data.allProduct);
            }).fail(function (error) {
                console.log(error);
            });
        }

        function specificSubCategory(categoryId, checkCreateOrUpdateSubCategory) {
            $.ajax({
                url: '{{route('specificSubCategory')}}',
                method: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': categoryId
                }
            }).done(function (data) {
                console.log(data);
                injectDynamicSubCategory(data.getSubCategory, checkCreateOrUpdateSubCategory);
            }).fail(function (error) {
                console.log(error);
            });
        }

        function getEditModalData(productId) {
            $.ajax({
                url: '{{route('getEditModalData')}}',
                method: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id': productId
                }
            }).done(function (data) {
                console.log(data);
                injectDynamicCategoryAndSubcategory(data.data);
            }).fail(function (error) {
                console.log(error);
            });
        }

        function injectDynamicDom(allProduct) {
            let html = '';
            for (let i = 0; i < allProduct.length; i++) {

                    html += '<li>' +
                    '<div class="row">' +
                    '<div class="col-md-4">' +
                    allProduct[i].name +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<button data-name="' + allProduct[i].name + '" data-id="' + allProduct[i].id + '" data-toggle="modal" data-target="#editModal" class="btn btn-outline-success float-right edit-product"> <i class="fa fa-edit"></i> </button>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<button data-id="' + allProduct[i].id + '" class="btn btn-outline-danger float-right delete-product"> <i class="fa fa-trash"></i> </button>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<button class="btn btn-outline-success float-right add-product-variation" ><a href="{{url('user/create-product-variation')}}/'+allProduct[i].id+'"><i class="fa fa-plus"></i></a> </button>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<button class="btn btn-outline-primary float-right edit-product-variation" ><a href="{{url('user/edit-product-variation')}}/'+allProduct[i].id+'"><i class="fa fa-edit"></i></a> </button>' +
                    '</div>' +
                    '</div>' +
                    '</li>' +
                    '<hr>';
            }
            $('#productList').html(html);
        }

        function resetInputFields() {
            $("#productName").val('');
            $("#categoryNameList").val('');
            $("#subCategoryNameList").val('');
            $(".sub-category-div").hide();
        }

        function injectDynamicCategoryAndSubcategory(data) {
            let categoryOptionTagHtml = '';
            for (let i = 0; i < data.categories.length; i++) {
                if (data.product.category_id === data.categories[i].id) {
                    categoryOptionTagHtml += '<option selected value = "' + data.categories[i].id + '">';
                    categoryOptionTagHtml += data.categories[i].name;
                    categoryOptionTagHtml += '</option>';
                } else {
                    categoryOptionTagHtml += '<option value = "' + data.categories[i].id + '">';
                    categoryOptionTagHtml += data.categories[i].name;
                    categoryOptionTagHtml += '</option>';
                }
            }

            $('#updateCategoryNameList').html(categoryOptionTagHtml);

            let subcategoryOptionTagHtml = '';
            for (let i = 0; i < data.subCategories.length; i++) {
                if (data.product.subcategory_id === data.subCategories[i].id) {
                    subcategoryOptionTagHtml += '<option selected value = "' + data.subCategories[i].id + '">';
                    subcategoryOptionTagHtml += data.subCategories[i].name;
                    subcategoryOptionTagHtml += '</option>';
                } else {
                    subcategoryOptionTagHtml += '<option value = "' + data.subCategories[i].id + '">';
                    subcategoryOptionTagHtml += data.subCategories[i].name;
                    subcategoryOptionTagHtml += '</option>';
                }
            }
            $('#updateSubCategoryNameList').html(subcategoryOptionTagHtml);
        }

        function injectDynamicSubCategory(getSubCategory, checkCreateOrUpdateSubCategory) {
            let html = '';
            for (let i = 0; i < getSubCategory.length; i++) {
                html += '<option value = "' + getSubCategory[i].id + '">' +
                    getSubCategory[i].name +
                    '</option>' +
                    '<hr>';
            }
            if (checkCreateOrUpdateSubCategory === "updateSubCategory") {
                $('#updateSubCategoryNameList').html(html);
            } else if (checkCreateOrUpdateSubCategory === "createSubCategory") {
                $('#subCategoryNameList').html(html);
            }

        }

    </script>
@endsection

