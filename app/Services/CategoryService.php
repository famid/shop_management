<?php


namespace App\Services;


use App\Models\Category;

class CategoryService
{
    protected $errorResponse;
    /**
     * CategoryService constructor.
     */
    public function __construct () {
        $this->errorResponse = [
            'success' => false,
            'message' => 'something went wrong'
        ];
    }

    /**
     * @return array
     */
    public function getAllCategory () {

        return Category::all();
    }

    /**
     * @param int $categoryId
     * @return array
     */
    public function category (int $categoryId): array {
        try {
            $category = Category::find($categoryId);
            if (is_null($category)) {

                return ['success' => false, 'message' => 'category is not found'];
            }

            return ['success' => true, 'message' => 'category is found', 'data' => $category];
        } catch (\Exception $e) {

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }

    /**
     * @param string $categoryName
     * @return array
     */
    public function create(string $categoryName): array
    {
        try {
            $createCategoryResponse = Category::create(['name' => $categoryName]);
            if (!$createCategoryResponse) {

                return $this->errorResponse;
            }

            return ['success' => true, 'message' => 'category has been created successfully'];

        } catch (\Exception $e) {

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }

    /**
     * @param int $categoryId
     * @param string $categoryName
     * @return array
     */
    public function update(int $categoryId, string $categoryName): array {
        try {
            $updateCategoryResponse = Category::where('id', $categoryId)->update(['name' => $categoryName]);
            if (!$updateCategoryResponse) {

                return $this->errorResponse;
            }

            return ['success' => true, 'message' => 'category has been updated successfully'];
        } catch (\Exception $e) {

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }

    /**
     * @param int $categoryId
     * @return array
     */
    public function delete(int $categoryId): array {
        $categoryDeleteResponse = Category::where('id', $categoryId)->delete();
        if (!$categoryDeleteResponse) {

            return $this->errorResponse;
        }

        return ['success' => true, 'message' => 'Category has been deleted successfully'];
    }
}
