<?php


namespace App\Services;


use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Collection;

class SubCategoryService
{
    protected $errorResponse;

    /**
     * SubCategoryService constructor.
     */
    public function __construct() {
        $this->errorResponse = [
            'success' => true,
            'message' => 'something went wrong'
        ];
    }

    /**
     * @return SubCategory[]|Collection
     */
    public function getAllSubCategory () {

        return SubCategory::all();
    }

    /**
     * @param int $subCategoryId
     * @return array
     */
    public function subCategory (int $subCategoryId) :array {
        try{
            $subCategory = SubCategory::find($subCategoryId);
            if (is_null($subCategory)) {

                return ['success' => false, 'message' => 'subCategory is not found'];
            }

            return ['success' => true, 'message' => 'subCategory is found', 'data' => $subCategory];
        } catch (\Exception $e){

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }

    /**
     * @param string $subCategoryName
     * @param int $categoryId
     * @return array
     */
    public function create (string $subCategoryName, int $categoryId) :array {
        try{
            $createSubCategoryResponse = SubCategory::create([
                'name' => $subCategoryName,
                'category_id' => $categoryId
            ]);
            if(!$createSubCategoryResponse) {

                return $this->errorResponse;
            }

            return ['success' => true, 'message' => 'subcategory has been created successfully'];
        } catch (\Exception $e){

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }

    /**
     * @param int $subCategoryId
     * @param string $subCategoryName
     * @param int $categoryId
     * @return array
     */
    public function update (int $subCategoryId, string $subCategoryName, int $categoryId) :array{
        try{
            $updateSubCategoryResponse = SubCategory::where('id',$subCategoryId)->update([
                'name' => $subCategoryName,
                'category_id' => $categoryId
            ]);
            if(!$updateSubCategoryResponse) {

                return $this->errorResponse;
            }

            return ['success' => true,'message' => 'subcategory has been updated successfully'];
        } catch (\Exception $e){

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }

    /**
     * @param int $subCategoryId
     * @return array
     */
    public function delete (int $subCategoryId) :array {
        $subCategoryDeleteResponse = SubCategory::where('id', $subCategoryId)->delete();
        if (!$subCategoryDeleteResponse) {

            return $this->errorResponse;
        }

        return ['success' => true, 'message' => 'subCategory has been deleted successfully'];
    }
}
