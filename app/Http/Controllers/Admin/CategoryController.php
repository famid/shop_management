<?php

namespace App\Http\Controllers\Admin;

use App\Services\CategoryService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected $categoryService;

    /**
     * CategoryController constructor.
     */
    public function __construct () {
        $this->categoryService = new CategoryService();
    }

    /**
     * @return Factory|View
     */
    public function showCreateCategory () {

        return view("admin.category.category");
    }

    /**
     * @return JsonResponse
     */
    public function getCategoryList () {
        $allCategory = $this->categoryService->getAllCategory();

        return response()->json([
            'success' =>true,
            'allCategory' =>$allCategory
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createCategory (Request $request) {
        $rules = [
            'name'=>'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()){

            return response()->json([
                'success'=>false,
                'message'=> $validator->errors()->first()
            ]);
        }
        $createCategoryResponse = $this->categoryService->create($request->name);
        if (!$createCategoryResponse['success']) {

            return response()->json([
                'success'=>$createCategoryResponse['success'],
                'message'=> $createCategoryResponse['message']
            ]);
        }

        return response()->json([
            'success'=> $createCategoryResponse['success'],
            'message'=> $createCategoryResponse['message']
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editCategory (Request $request) {
        try {
            $category = $this->categoryService->category($request->id);
            if (!$category['success']) {

                return response()->json([
                    'success' =>$category['success'],
                    'error' =>$category['message']
                ]);
            }
            $data = $category['data'];

            return response()->json([
                'success'=> $category['success'],
                'message'=> $category['message'],
                'data'=> $data
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success'=> $category['success'],
                'message'=> $category['message']
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function updateCategory (Request $request) {
        $rules = [
            'name'=>'required',
            'id'=>'integer',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()){

            return response()->json([
                'success'=>false,
                'message'=> $validator->errors()->first()
            ]);
        }
        $updateCategoryResponse = $this->categoryService->update(
            $request->id,
            $request->name
        );
        if (!$updateCategoryResponse['success']) {

            return redirect()->back()->with('error',$updateCategoryResponse['message']);
        }

        return response()->json([
            'success'=> $updateCategoryResponse['success'],
            'message'=> $updateCategoryResponse['message']
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteCategory(Request $request) {
        $rules = ['id' => 'integer'];
        $validator =Validator::make($request->all(),$rules);
        if ($validator->fails()){

            return response()->json([
                'success'=>false,
                'message'=> $validator->errors()->first()
            ]);
        }
        $deleteCategoryResponse = $this->categoryService->delete($request->id);
        if (!$deleteCategoryResponse['success']) {

            return response()->json([
                'error' =>$deleteCategoryResponse['message'],
            ]);
        }

        return response()->json([
            'success'=>$deleteCategoryResponse['success'],
            'message'=>$deleteCategoryResponse['message']
        ]);
    }
}
