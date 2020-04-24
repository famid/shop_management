<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function (Request $request) {
    if(Auth::check() && Auth::user()->role == 'admin') {
        return redirect()->route('admin.home');
    } else if(Auth::check() && Auth::user()->role == 'shopkeeper') {
        return redirect()->route('shopkeeper.home');
    } else {
        return redirect(route('login'));
    }
})->name('root');

Auth::routes();

Route::middleware(['admin'])->namespace('Admin')->prefix('admin')->group(function () {
    /*
     * ------------------------------------------------------------------------
     * HOME ROUTES
     * ------------------------------------------------------------------------
     * */
    Route::get('/home', 'HomeController@index')->name('admin.home');
    /*
     * ------------------------------------------------------------------------
     * CATAGORY ROUTES
     * ------------------------------------------------------------------------
     * */
    Route::get('/get-category-list', 'CategoryController@getCategoryList')->name('getCategoryList');
    Route::get('/create-category', 'CategoryController@showCreateCategory')->name('createCategory');
    Route::post('/create-category', 'CategoryController@createCategory')->name('createCategory');
    Route::post('/delete-category/id', 'CategoryController@deleteCategory')->name('deleteCategory');
    Route::get('/edit-category/id', 'CategoryController@editCategory')->name('editCategory');
    Route::post('/update-category/id', 'CategoryController@updateCategory')->name('updateCategory');
    /*
     * ------------------------------------------------------------------------
     * SUBCATAGORY ROUTES
     * ------------------------------------------------------------------------
     * */
    Route::get('/get-sub-category-list', 'SubCategoryController@getSubCategoryList')->name('getSubCategoryList');
    Route::get('/create-sub-category', 'SubCategoryController@showCreateSubCategory')->name('createSubCategory');
    Route::post('/create-sub-category', 'SubCategoryController@createSubCategory')->name('createSubCategory');
    Route::post('/delete-sub-category/id', 'SubCategoryController@deleteSubCategory')->name('deleteSubCategory');
    Route::get('/edit-sub-category/id', 'SubCategoryController@ editSubCategory')->name(' editSubCategory');
    Route::post('/update-sub-category/id', 'SubCategoryController@updateSubCategory')->name('updateSubCategory');



});

Route::middleware(['shopkeeper'])->namespace('Shopkeeper')->prefix('user')->group(function (){
    /*
     * ------------------------------------------------------------------------
     * HOME ROUTES
     * ------------------------------------------------------------------------
     * */
    Route::get('/home', 'HomeController@index')->name('shopkeeper.home');
    /*
     * ------------------------------------------------------------------------
     * PRODUCTS ROUTES
     * ------------------------------------------------------------------------
     * */
    Route::get('/get-product-list', 'ProductController@getProductList')->name('getProductList');
    Route::get('/create-product', 'ProductController@createProduct')->name('createProduct');
    Route::post('/store-product', 'ProductController@storeProduct')->name('storeProduct');
    Route::post('/delete-product/id', 'ProductController@deleteProduct')->name('deleteProduct');
    Route::get('/edit-product/id', 'ProductController@editProduct')->name('editProduct');
    Route::post('/update-product/id', 'ProductController@updateProduct')->name('updateProduct');
    Route::get('/get-specific-sub-category/id', 'ProductController@specificSubCategory')->name('specificSubCategory');
    Route::post('/get-edit-modal-data/id', 'ProductController@getEditModalData')->name('getEditModalData');

    /*
     * -------------------------------------------------
     * PRODUCT VARIATION
     * -------------------------------------------------
     */
    Route::get('/get-product-variation-list', 'ProductVariationController@getProductVariationList')->name('getProductVariationList');
    Route::get('/create-product-variation/{id}', 'ProductVariationController@createProductVariation')->name('createProductVariation');
    Route::post('/store-product-variations', 'ProductVariationController@storeProductVariations')->name('storeProductVariations');
    Route::get('/edit-product-variation/{id}', 'ProductVariationController@editProductVariation')->name('editProductVariation');
    Route::post('/update-product-variation', 'ProductVariationController@updateProductVariation')->name('updateProductVariation');
    //Route::post('/delete-product-variation/id', 'ProductVariationController@deleteProductVariation')->name('deleteProductVariation');
    /*
     * -------------------------------------------------
     * EMPLOYEE
     * -------------------------------------------------
     */
    Route::get('/get-employee-list', 'EmployeeController@getEmployeeList')->name('getEmployeeList');
    Route::get('/create-employee', 'EmployeeController@createEmployee')->name('createEmployee');
    Route::post('/store-employee', 'EmployeeController@storeEmployee')->name('storeEmployee');
    Route::post('/delete-employee/id', 'EmployeeController@deleteEmployee')->name('deleteEmployee');
    Route::get('/get-modal-data/id', 'EmployeeController@getModalData')->name('getModalData');
    Route::post('/update-employee/id', 'EmployeeController@updateEmployee')->name('updateEmployee');

    /*
     * ----------------------------------
     * filter
     * ----------------------------------
     * */
    Route::get('/create-filter','FilterController@createFilter')->name('createFilter');
    Route::get('/create-employee-filter','FilterController@createEmployeeFilter')->name('createEmployeeFilter');
    Route::get('/get-filter-result','FilterController@getFilterResult')->name('getFilterResult');
    Route::get('/get-employee-filter-result','FilterController@getEmployeeFilterResult')->name('getEmployeeFilterResult');
    Route::get('/export', 'FilterController@export')->name('export');
    /*    Route::get('/search/product','FilterController@searchProduct')->name('searchProduct');*/
});
