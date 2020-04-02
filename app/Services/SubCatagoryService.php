<?php


namespace App\Services;


class SubCatagoryService
{
    /**
     * SubCatagoryService constructor.
     */
    public function __construct() {
        $this->errorResponse = [
            'success' => true,
            'message' =>'someting went wrong'
        ];
    }
    public function getAllSubCatagory () {

    }

    /**
     * @param int $subCatagoryId
     * @return array
     */
    public function subCatagory (int $subCatagoryId) :array{
        try{

        } catch (\Exception $e){

        }
    }

    /**
     * @param string $subCatagoryName
     * @param int $catagoryId
     * @return array
     */
    public function create (string $subCatagoryName, int $catagoryId) :array{
        try{

        } catch (\Exception $e){

        }
    }

    /**
     * @param int $subCatagoryId
     * @param string $subCatagoryName
     * @param int $catagoryId
     * @return array
     */
    public function update (int $subCatagoryId, string $subCatagoryName, int $catagoryId) :array{
        try{

        } catch (\Exception $e){

        }
    }

    /**
     * @param int $subCatagoryId
     * @return array
     */
    public function delete (int $subCatagoryId) :array{

    }
}
