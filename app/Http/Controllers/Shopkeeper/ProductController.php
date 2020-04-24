<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected  $productService;
    /**
     * ProductController constructor.
     */
    public function __construct() {
        $this->productService = new ProductService();
    }

    /**
     * @return Factory|View
     */
    public function createProduct() {
        $category['categories'] = Category::all();

        return view("shopkeeper.product.product", $category);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function specificSubCategory(Request $request) {
        $specificSubcategory = $this->productService->getSpecificSubCategory($request->id);
        $getSubCategory = $specificSubcategory['success'] ? $specificSubcategory['data'] : [];
        $success = $specificSubcategory['success'] ? true : false;

        return response()->json([
            'success' => $success,
            'getSubCategory' => $getSubCategory,
            'message' => $specificSubcategory['message']
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getProductList() {
        $getAllProductResponse = $this->productService->getAllProduct();
        $success = $getAllProductResponse['success'] ? true:false;
         $allProduct = $getAllProductResponse['success'] ? $getAllProductResponse['data']:'';

        return response()->json([
            'success' => $success,
            'allProduct' => $allProduct
        ]);
    }

     /**
      * @param Request $request
      * @return JsonResponse
      */
     public function storeProduct(Request $request) {
         $rules = [
             'name' => 'string',
             'shopId' => 'integer',
             'category_id' => 'integer',
             'subcategory_id' => 'integer'
         ];
         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {

             return response()->json([
                 'success' => false,
                 'message' => $validator->errors()->first()
             ]);
         }
         $createProductResponse = $this->productService->create(
             $request->name,
             $request->shop_id,
             $request->category_id,
             $request->subcategory_id
         );
         $success = $createProductResponse['success'] ? true : false;
         $message = $createProductResponse['success'] ? $createProductResponse['message'] : 'something went wrong';

         return  response()->json([
             'success' => $success,
             'message' => $message
         ]);
     }

      /**
       * @param Request $request
       * @return JsonResponse
       */

      public function updateProduct(Request $request) {
          $rules = [
              'id' => 'integer',
              'name' => 'required',
              'shopId' => 'integer',
              'category_id' => 'integer',
              'subcategory_id' => 'integer'
          ];
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {

              return response()->json([
                  'success' => false,
                  'message' => $validator->errors()->first()
              ]);
          }
          $updateProductResponse = $this->productService->update(
              $request -> id,
              $request -> name,
              $request -> shop_id,
              $request -> category_id,
              $request -> subcategory_id
         );
          $success = $updateProductResponse['success'] ? true : false;
          $message = $updateProductResponse['success'] ? $updateProductResponse['message'] : 'something went wrong';

          return response()->json([
              'success' => $success,
              'message' => $message
          ]);
      }

      /**
       * @param Request $request
       * @return JsonResponse
       */
      public  function  deleteProduct (Request $request) {
          $rules = ['id' => 'integer'];
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()){

              return response()->json([
                  'success' => false,
                  'error' => $validator->errors()->first()
              ]);
          }
          $deleteProductResponse = $this->productService->delete($request->id);
          if (!$deleteProductResponse['message']) {

              return response()->json([
                  'success' => $deleteProductResponse['success'],
                  'error' => $deleteProductResponse['message']
              ]);
          }

          return response()->json([
              'success' => $deleteProductResponse['success'],
              'error' => $deleteProductResponse['message']
          ]);
      }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getEditModalData(Request $request) {
          $rules = ['id' => 'integer'];
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()){

              return response()->json(['success' => false, 'error' => $validator->errors()->first()]);
          }
          $productEditModalDataResponse= $this->productService->getProductEditModalData($request->id);
          $success = $productEditModalDataResponse['success'] ? true:false;
          $productEditModalData = $productEditModalDataResponse['success'] ? $productEditModalDataResponse['data'] :'';
          $message = $productEditModalDataResponse['success'] ? $productEditModalDataResponse['message'] : $productEditModalDataResponse['message'];

          return response()->json([
              'success' => $success,
              'message' => $message,
              'data' =>  $productEditModalData
          ]);
      }
}
