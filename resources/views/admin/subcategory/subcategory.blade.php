@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="background-color: #191d1f">
                    <div class="card-header" style="background-color: #000000"> <span>Create Your SubCategory</span></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="custom-input-label" for="subCategoryName">SubCategory Name:</label>
                            <input type="text" id="subCategoryName" class="form-control custom-input-field " name="name" value="">
                        </div>
                        <div class="form-group">
                            <label class="custom-input-label" for="categoryNameList">select your Category:</label>
                            <select id="categoryNameList" class="mdb-select md-form form-control">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group pt-4">
                            <button id="save-subcategory-button" type="submit" class="btn btn-outline-success ">Save</button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">SubCategory</div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <span>SubCategory Name</span>
                                </div>
                                <div class="col-md-2">
                                    <span>Edit</span>
                                </div>
                                <div class="col-md-2">
                                    <span>Delete</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ol id="subCategoryList">

                            </ol>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit SubCategory</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editSubCategoryName">SubCategory Name</label>
                        <input type="hidden" name="id" id="editSubCategoryId" value="">
                        <input type="text" name="name" value="" class="form-control" id="editSubCategoryName">
                    </div>
                    <div class="form-group">
                        <label class="custom-input-label" for="categoryNameList">select your Category:</label>
                        <select id="updateCategoryNameList" class="mdb-select md-form form-control">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update-subCategory"data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            getAllSubCategory();
            //Events
            $("#save-subcategory-button").on('click', function(){

                let subCategoryName = $("#subCategoryName").val();
                let categoryId = $("#categoryNameList").val();
                console.log(subCategoryName);
                console.log(categoryId);
                saveSubCategory(subCategoryName,categoryId)
            });
            $("#subCategoryList").on('click','.delete-subCategory',function () {
                let subCategoryId = $(this).data('id');
                deleteSubCategory(subCategoryId);
            });
            $("#subCategoryList").on('click','.edit-subCategory',function () {

                let subCategoryId = $(this).data('id');
                let subCategoryName = $(this).data('name');
                $("#editSubCategoryId").val(subCategoryId);
                $("#editSubCategoryName").val(subCategoryName);
            });
            $('.update-subCategory').click(function () {
                let subCategoryId = $("#editSubCategoryId").val();
                let subCategoryName = $("#editSubCategoryName").val();
                let categoryId = $("#updateCategoryNameList").val();
                updateSubCategory(subCategoryId,subCategoryName,categoryId);
            });

        });
        //Methods
        function saveSubCategory(subCategoryName,categoryId) {
            $.ajax({
                url: '{{route('createSubCategory')}}',
                method: 'POST',
                data:{
                    '_token': '{{csrf_token()}}',
                    'name':subCategoryName,
                    'category_id':categoryId
                }
            }).done(function (data) {
                console.log(data);
                getAllSubCategory();
                resetInputFields();
            }).fail(function (error) {
                console.log(error);
            });
        }
        function updateSubCategory(subCategoryId,subCategoryName,categoryId) {
            $.ajax({
                url: '{{route('updateSubCategory')}}',
                method: 'POST',
                data:{
                    '_token': '{{csrf_token()}}',
                    'id':subCategoryId,
                    'name':subCategoryName,
                    'category_id':categoryId
                }
            }).done(function (data) {
                console.log(data);
                getAllSubCategory();
                resetInputFields();
            }).fail(function (error) {
                console.log(error);
            });
        }

        function deleteSubCategory(subCategoryId) {
            $.ajax({
                url:'{{route('deleteSubCategory')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    'id':subCategoryId
                }
            }).done(function (data) {
                console.log(data);
                getAllSubCategory();
            }).fail(function (error) {
                console.log(error);
            });
        }
        function getAllSubCategory() {
            $.ajax({
                url:'{{route('getSubCategoryList')}}',
                method: 'GET',
            }).done(function (data) {
                console.log(data);
                injectDynamicDom(data.allSubCategory);
            }).fail(function (error) {
                console.log(error);
            });
        }
        function injectDynamicDom(allSubCategory) {
            let html = '';
            for (let i = 0; i < allSubCategory.length; i++) {
                html+='<li>'+
                    '<div class="row">'+
                    '<div class="col-md-6">'+
                    allSubCategory[i].name +
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<button data-name="'+allSubCategory[i].name+'" data-id="'+allSubCategory[i].id+'" data-toggle="modal" data-target="#editModal" class="btn btn-outline-success float-right edit-subCategory"> <i class="fa fa-plus"></i> </button>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<button data-id="'+allSubCategory[i].id+'" class="btn btn-outline-danger float-right delete-subCategory"> <i class="fa fa-trash"></i> </button>'+
                    '</div>'+
                    '</div>'+
                    '</li>'+
                    '<hr>';
            }
            $('#subCategoryList').html(html);
        }
        function resetInputFields() {
            $("#subCategoryName").val('');
        }
        function getAllCategory() {
            $.ajax({
                url:'{{route('getCategoryList')}}',
                method: 'GET',
            }).done(function (data) {
                console.log(data);
                injectDynamicOption(data.allCategory);
            }).fail(function (error) {
                console.log(error);
            });
        }

    </script>
@endsection
