<?php


namespace App\Services;


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
    public function getAllProductVariation () :array{

    }

    /**
     * @param int $productVariationId
     * @return array
     */
    public function productVariation (int $productVariationId) :array{
        try{

        } catch (\Exception $e){

        }
    }

    /**
     * @param int $quantity
     * @param float $price
     * @param string $status
     * @param int $productId
     * @return array
     */
    public function create (int $quantity, float $price, string $status, int $productId) :array{
        try{

        } catch (\Exception $e){

        }
    }

    /**
     * @param int $productVariationId
     * @param int $quantity
     * @param float $price
     * @param string $status
     * @param int $productId
     * @return array
     */
    public function update (int $productVariationId, int $quantity, float $price, string $status, int $productId) :array{
        try{

        } catch (\Exception $e){

        }
    }

    /**
     * @param int $productVariationId
     * @return array
     */
    public function delete (int $productVariationId) :array{

    }
}
