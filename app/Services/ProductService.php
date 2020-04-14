<?php


namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected $errorResponse;
    protected $productVariationService;

    /**
     * ProductService constructor.
     */
    public function __construct () {
        $this->productVariationService = new ProductVariationService();
        $this->errorResponse = [
            'success' => false,
            'message' => 'something went wrong'
        ];
    }

    /**
     * @return Product[]|Collection
     */
    public function getAllProduct () {

        return Product::all();
    }

    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getSpecificSubCategory (int $categoryId) {
        $subCategory = Category::find($categoryId)->subCategories;
        if (is_null($subCategory)) {

            return ['success' => false, 'message' => 'subcategory is not found',];
        }

        return ['success' => true, 'message' => 'subcategory is found', 'data' => $subCategory];
    }

    /**
     * @param int $productId
     * @return array
     */
    public function product (int $productId): array {
        try {
            $product = Product::find($productId);
            if (is_null($product)) {

                return ['success' => false, 'message' => 'product is not found'];
            }

            return ['success' => true, 'message' => 'product is found', 'data' => $product];
        } catch (\Exception $e) {

            return ['success'=>false,'message'=>[$e->getMessage()]];
        }
    }

    /**
     * @param string $productName
     * @param int $shopId
     * @param int $categoryId
     * @param int $subCategoryId
     * @return array
     */
    public function create (string $productName, int $shopId, int $categoryId, int $subCategoryId): array {
        try {
            $createProductResponse = Product::create([
                'name' => $productName,
                'shop_id' => $shopId,
                'category_id' => $categoryId,
                'subcategory_id' => $subCategoryId
            ]);
            if (!$createProductResponse) {

                return $this->errorResponse;
            }

            return ['success' => true, 'message' => 'product has been created successfully'];
        } catch (\Exception $e) {

            return ['success'=>false,'message'=>[$e->getMessage()]];
        }
    }

    /**
     * @param int $productId
     * @param string $productName
     * @param int $shopId
     * @param int $categoryId
     * @param int $subCategoryId
     * @return array
     */
    public function update(int $productId, string $productName, int $shopId, int $categoryId, int $subCategoryId): array {
        try {
            $createProductResponse = Product::where('id', $productId)->update([
                'name' => $productName,
                'shop_id' => $shopId,
                'category_id' => $categoryId,
                'subcategory_id' => $subCategoryId
            ]);
            if (!$createProductResponse) {

                return $this->errorResponse;
            }

            return ['success' => true, 'message' => 'product has been created successfully'];
        } catch (\Exception $e) {

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }

    /**
     * @param int $productId
     * @return array
     */

    public function delete(int $productId): array {
        try {
            DB::beginTransaction();
            $productDeleteResponse = Product::where('id', $productId)->delete();
            $productVariationsDeleteResponse = $this->productVariationService->deleteVariationsByProductId($productId);
            if (!$productDeleteResponse && !$productVariationsDeleteResponse) {
                DB::rollBack();

                return $this->errorResponse;
            }
            DB::commit();

            return [
                'success' => true,
                'message' => 'Product has been deleted successfully'
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->errorResponse;
        }
    }

    public function getProductEditModalData($productId) {
        $data['product'] = Product::select(
                'products.id as product_id',
                'products.name as product_name',
                'products.category_id',
                'products.subcategory_id',
                'categories.id as category_id',
                'categories.name as category_name',
                'sub_categories.id as subcategory_id',
                'sub_categories.name as subcategory_name'
            )
            ->leftJoin('categories', ['products.category_id' => 'categories.id'])
            ->leftJoin('sub_categories', ['products.subcategory_id' => 'sub_categories.id'])
            ->where('products.id', $productId)
            ->first();
        $data['categories'] = Category::all();
        $data['subCategories'] = SubCategory::where('category_id', $data['product']->category_id)->get();

        return $data;
    }
}
