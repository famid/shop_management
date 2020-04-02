<?php


namespace App\Services;


class ProductService
{
    /**
     * ProductService constructor.
     */
    public function __construct() {
        $this->errorResponse = [
            'success' => true,
            'message' =>'someting went wrong'
        ];
    }
    public function getAllProduct () :array{

    }
    public function product (int $productId) :array{
        try{

        } catch (\Exception $e){

        }
    }
    public function create (string $productName,int $catagoryId,int $subCatagoryId) :array{
        try{

        } catch (\Exception $e){

        }
    }
    public function update (int $productId,string $productName,int $catagoryId,int $subCatagoryId) :array{
        try{

        } catch (\Exception $e){

        }
    }
    public function delete (int $productId) :array{

    }
}
