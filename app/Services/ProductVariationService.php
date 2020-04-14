<?php


namespace App\Services;


use App\Models\Product;
use App\Models\ProductVariation;

class ProductVariationService
{
    /**
     * ProductVariationService constructor.
     */
    public function __construct() {
        $this->errorResponse = [
            'success' => true,
            'message' =>'someting went wrong'
        ];
    }

    /**
     * @return array
     */
    public function getAllProductVariation () {

        return ProductVariation::all();
    }

    /**
     * @param int $productVariationId
     * @return array
     */
    public function productVariation (int $productVariationId) :array {
        try{
            $productVariation = ProductVariation::find($productVariationId);
            if (is_null($productVariation)) {

                return ['success' => false, 'message'=> 'production Id not found '];
            }

            return ['success' => true, 'message'=> 'product variation is found' , 'data' => $productVariation];
        } catch (\Exception $e){

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }

    /**
     * @param $data
     * @return array
     */
    protected function productVariationData ($data) {
        /*

        --------------------------------------------------
        This is what we will receive

        $data = [
            'quantities' => [1,2,3,4],
            'price' => [1,2,3,4],
            'status' => [ACTIVE, ACTIVE, ACTIVE, INACTIVE],
        ];

        --------------------------------------------------
        This is what we will build using for loop

        $productVariationData = [
            [
                'quantity' => 1,
                'price' => 1,
                'status' => ACTIVE
            ],[
                'quantity' => 2,
                'price' => 2,
                'status' => ACTIVE
            ],[
                'quantity' => 3,
                'price' => 3,
                'status' => ACTIVE
            ],[
                'quantity' => 4,
                'price' => 4,
                'status' => INACTIVE
            ],
        ];
        --------------------------------------------------
        */
        $allProductVariationData = [];
        foreach ($data['quantities'] as $key => $quantity) {
            $arrayData = [
                'quantity' => $quantity,
                'price' => $data['prices'][$key],
                'status' => $data['status'][$key],
                'product_id' => $data['product_id']
            ];
            array_push($allProductVariationData, $arrayData);
        }

        return $allProductVariationData;
    }

    /**
     * @param array $data
     * @return array
     */
    public function create (array $data) :array {
        try {
            $allProductVariationData = $this->productVariationData($data);
            foreach ($allProductVariationData as $key => $productVariationData) {
                $createProductVariationResponse = ProductVariation::create($productVariationData);
            }
            if (!$createProductVariationResponse) {

                return $this->errorResponse;
            }

            return ['success' => true, 'message' => 'product variation has been stored successfully'];
        } catch (\Exception $e){

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }

    /**
     * @param int $productVariationId
     * @return array
     */
    public function delete (int $productVariationId) :array{
        $deleteProductVariationResponse = ProductVariation::where('id', $productVariationId)->delete();
        if (!$deleteProductVariationResponse) {

            return $this->errorResponse;
        }

        return ['success' => true, 'message' => 'productVariation has been deleted successfully'];
    }

    /**
     * @param int $productId
     * @return array
     */
    public function deleteVariationsByProductId (int $productId) :array{
        $deleteProductVariationResponse = ProductVariation::where('product_id', $productId)->delete();
        if (!$deleteProductVariationResponse) {

            return $this->errorResponse;
        }

        return ['success' => true, 'message' => 'productVariations has been deleted successfully'];
    }

    /**
     * @param int $productId
     * @return array
     */
    public function getSpecificProductVariation (int $productId) {
        $productVariations = Product::find($productId)->productVariations;

        if (sizeof($productVariations) <= 0) {

            return ['success' => false, 'message' => 'product variations is not found',];
        }else{

            return ['success' => true, 'message' => 'product variations is found ', 'data' => $productVariations];
        }
    }
}
