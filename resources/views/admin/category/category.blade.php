@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="background-color: #191d1f">
                    <div class="card-header"style="background-color: #000000"> <span>Create Your Category</span></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="custom-input-label" for="categoryName">Category Name:</label>
                            <input type="text" id="categoryName" class="form-control custom-input-field" name="name" value="">
                        </div>

                        <div class="form-group pt-4">
                            <button id="submit" class="btn btn-outline-success">Save</button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Category</div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <span>Category Name</span>
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
                            <ol id="categoryList">

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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categoryName">Name</label>
                        <input type="hidden" name="id" id="editCategoryId" value="">
                        <input type="text" name="name" value="" class="form-control" id="editCategoryName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary update-category"data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            getAllCategory();
            //Events
            $("#submit").on('click', function(){
                let categoryName = $("#categoryName").val();
                saveCategory(categoryName);
            });
            $("#categoryList").on('click','.delete-category',function () {
                let categoryId = $(this).data('id');
                deleteCategory(categoryId);
            });
            $("#categoryList").on('click','.edit-category',function () {
                let categoryId = $(this).data('id');
                let categoryName = $(this).data('name');
                $("#editCategoryId").val(categoryId);
                $("#editCategoryName").val(categoryName);
            });
            $('.update-category').click(function () {
                let categoryId = $("#editCategoryId").val();
                let categoryName = $("#editCategoryName").val();
                updateCategory(categoryId,categoryName);
            });
        });
        //Methods
        function saveCategory(categoryName) {
            $.ajax({
                url: '{{route('createCategory')}}',
                method: 'POST',
                data:{
                    '_token': '{{csrf_token()}}',
                    'name':categoryName,
                }
            }).done(function (data) {
                console.log(data);
                getAllCategory();
                resetInputFields();
            }).fail(function (error) {
                console.log(error);
            });
        }
        function updateCategory(categoryId,categoryName) {
           $.ajax({
                url: '{{route('updateCategory')}}',
                method: 'POST',
                data:{
                    '_token': '{{csrf_token()}}',
                    'id':categoryId,
                    'name':categoryName,
                }
            }).done(function (data) {
                console.log(data);
               getAllCategory();
               resetInputFields();
            }).fail(function (error) {
                console.log(error);
            });
        }

        function deleteCategory(categoryId) {
            $.ajax({
                url:'{{route('deleteCategory')}}',
                method:'POST',
                data:{
                    '_token':'{{csrf_token()}}',
                    'id':categoryId
                }
            }).done(function (data) {
                console.log(data);
                getAllCategory();
            }).fail(function (error) {
                console.log(error);
            });
        }
        function getAllCategory() {
            $.ajax({
                url:'{{route('getCategoryList')}}',
                method: 'GET',
            }).done(function (data) {
                console.log(data);
                injectDynamicDom(data.allCategory);
            }).fail(function (error) {
                console.log(error);
            });
        }
       function injectDynamicDom(allCategory) {
            let html = '';
            for (let i = 0; i < allCategory.length; i++) {
                html+='<li>'+
                    '<div class="row">'+
                    '<div class="col-md-6">'+
                    allCategory[i].name +
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<button data-name="'+allCategory[i].name+'" data-id="'+allCategory[i].id+'" data-toggle="modal" data-target="#editModal" class="btn btn-outline-success float-right edit-category"> <i class="fa fa-plus"></i> </button>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                    '<button data-id="'+allCategory[i].id+'" class="btn btn-outline-danger float-right delete-category"> <i class="fa fa-trash"></i> </button>'+
                    '</div>'+
                    '</div>'+
                    '</li>'+
                    '<hr>';
            }
            $('#categoryList').html(html);
        }
       function resetInputFields() {
            $("#categoryName").val('');
        }
    </script>
@endsection
