<?php


namespace App\Services;


use App\Models\Employee;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class FilterService
{
    /**
     * @param array $data
     * @return mixed
     */
    public function filter (array $data) {
        $categoryId = $data['category_id'];
        $subCategoryId = $data['subcategory_id'];
        $price = $data['price'];
        $quantity = $data['quantity'];
        $quantity_min_value = $data['quantity_min'];
        $quantity_max_value = $data['quantity_max'];
        $price_min_value = $data['price_min'];
        $price_max_value = $data['price_max'];
        $productName = $data['product_name'];
        $shopId = Shop::where('user_id', Auth::id())->first()->id;
        try{
            $data = Product::select(
                'products.name as product_name',
                'product_variations.price as product_price',
                'product_variations.quantity as product_quantity'
            )
                ->leftJoin('categories', ['products.category_id' => 'categories.id'])
                ->leftJoin('sub_categories', ['products.subcategory_id' => 'sub_categories.id'])
                ->leftJoin('product_variations', ['product_variations.product_id' => 'products.id']);
            if(!is_null($shopId)) {
                $data->where('products.shop_id', $shopId);
            }
            if (!is_null($categoryId)) {
                $data->whereIn('categories.id', $categoryId);
            }
            if (!is_null($subCategoryId)) {
                $data->whereIn('sub_categories.id', $subCategoryId);
            }
            if (!is_null($price)) {
                $data->where('product_variations.price', $price);
            } else if (!(is_null($price_min_value) && is_null($price_max_value))) {
                $data->whereBetween('product_variations.price', [$price_min_value, $price_max_value]);
            }
            if (!is_null($quantity)) {
                $data->where('product_variations.quantity', $quantity);
            } else if (!(is_null($quantity_min_value) && is_null($quantity_max_value))) {
                $data->whereBetween('product_variations.quantity', [$quantity_min_value, $quantity_max_value]);
            }
            if (!is_null($productName)) {
                $data->where('products.name', 'LIKE', "%{$productName}%")->where('product_variations.price','!=', null);
            }

            return ['success' => true, 'data' => $data->get()];
        }catch(\Exception $e){

            return ['success'=>false,'message'=>[$e->getMessage()]];
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function employeeFilterBySalaryAndDate (array $data) {
        $employeeSalary = $data['salary'];
        $employeeMinSalaryRange = $data['min_salary'];
        $employeeMaxSalaryRange = $data['max_salary'];
        $startedAt = $data['started_at'];
        $endedAt = $data['ended_at'];
        $employeeName = $data['employee_name'];
        $shopId = Shop::where('user_id', Auth::id())->first()->id;
        try{
            $data = Employee::select(
                'employees.name as employee_name',
                'employees.salary as employee_salary',
                'employees.started_at as employee_started_at',
                'employees.ended_at as employee_ended_at'
            ) ;
            if(!is_null($shopId)) {
                $data->where('employees.shop_id', $shopId);
            }
            if (!is_null($employeeSalary)) {
                $data->where('employees.salary', $employeeSalary);
            }else if (!(is_null($employeeMinSalaryRange) && is_null($employeeMaxSalaryRange))){
                $data->whereBetween('employees.salary',[$employeeMinSalaryRange,$employeeMaxSalaryRange]);
            }
            if (!(is_null($startedAt) && is_null($endedAt))) {
                $data->where('employees.started_at','>=',$startedAt)
                    ->where('employees.ended_at','<=',$endedAt);
            }
            if (!is_null($employeeName)) {
                $data->where('employees.name','LIKE',"%{$employeeName}%");
            }

            return ['success' => true, 'data' => $data->get()];
        }catch(\Exception $e){

            return ['success' => false, 'message' => [$e->getMessage()]];
        }
    }
}
