<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Product;
use App\Services\ProductVariationService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProductVariationController extends Controller
{
    protected $productVariationService;

    /**
     * ProductVariationController constructor.
     */
    public function __construct() {
        $this->productVariationService = new ProductVariationService();
    }

    /**
     * @return JsonResponse
     */
    public function getProductVariationList () {
        $allProductVariation = $this->productVariationService->getAllProductVariation();

        return response()->json([
            'success' => true,
            'allProductVariation' => $allProductVariation
        ]);
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function createProductVariation (Request $request) {
        $data ['product'] = Product::find($request->id);

        return view('shopkeeper.productvariation.productvariation', $data);
    }

    /**
     * @param Request $request
     * @return Factory|RedirectResponse|View
     */
    public function editProductVariation (Request $request) {
        $getProductVariations = $this->productVariationService->getSpecificProductVariation($request->id);
        if ($getProductVariations['success']) {
            $data['getProductVariations'] = $getProductVariations['data'];

            return view('shopkeeper.productvariation.editproductvariation',$data);
        }

        return redirect()->route('createProduct')->with(['success'=> false, 'error' => $getProductVariations['message']]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeProductVariations (Request $request) {
        $rules = [
            'quantities' => 'required',
            'prices' => 'required',
            'status' => 'required',
            'product_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        $data = $request->all();
        $createProductVariationResponse = $this->productVariationService->create(
            $data
         );
        $success = $createProductVariationResponse['success'] ? true : false;
        $message = $createProductVariationResponse['success'] ? $createProductVariationResponse['message'] : 'something went wrong';

        return  response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProductVariation (Request $request) {
        $rules = [
            'quantities' => 'required',
            'prices' => 'required',
            'status' => 'required',
            'product_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        $deleteProductVariationResponse = $this->productVariationService->deleteVariationsByProductId($request->product_id);
        if(!$deleteProductVariationResponse) {

            return response()->json(['success' => false, 'message' => $deleteProductVariationResponse['message']]);
        }
        $data = $request->all();
        $updateProductVariationResponse = $this->productVariationService->create($data);
        $success = $updateProductVariationResponse['success'] ? true : false;
        $message = $updateProductVariationResponse['success'] ? $updateProductVariationResponse['message'] : 'something went wrong';

        return  response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteProductVariation (Request $request) {
        $rules = ['id' => 'integer'];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        $deleteProductVariationResponse = $this->productVariationService->delete($request->id);
        $success = $deleteProductVariationResponse['success'] ? true : false ;
        $message = $deleteProductVariationResponse['success'] ? $deleteProductVariationResponse['message'] : 'product variation is not deleted' ;

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
