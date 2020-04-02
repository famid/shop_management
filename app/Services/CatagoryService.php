<?php


namespace App\Services;


class CatagoryService
{
    protected $errorResponse;

    /**
     * CatagoryService constructor.
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
    public function getAllCatagory () :array {

    }

    /**
     * @param int $catagoryId
     * @return array
     */
    public function catagory (int $catagoryId) :array{
       try{

       } catch (\Exception $e){

       }
    }

    /**
     * @param string $catagoryName
     * @return array
     */
    public function create (string $catagoryName) :array{
         try{

         } catch (\Exception $e){

         }
     }

    /**
     * @param int $catagoryId
     * @param string $catagoryName
     * @return array
     */
    public function update (int $catagoryId, string $catagoryName) :array{
         try{

         } catch (\Exception $e){

         }
     }

    /**
     * @param int $catagoryId
     * @return array
     */
    public function delete (int $catagoryId) :array{

     }
}
