<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Services\SubCategoryService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SubCategoryController extends Controller
{
    protected $subCategoryService;

    /**
     * SubCategoryController constructor.
     */
    public function __construct() {
        $this->subCategoryService = new SubCategoryService();
    }

    /**
     * @return Factory|View
     */
    public function showCreateSubCategory () {
        $data['categories'] = Category::all();

        return view("admin.subcategory.subcategory", $data);
    }


    /**
     * @return JsonResponse
     */
    public function getSubCategoryList() {
        $allSubCategory = $this->subCategoryService->getAllSubCategory();

        return response()->json([
            'success' => true,
            'allSubCategory' => $allSubCategory
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createSubCategory(Request $request) {
        $rules = [
            'name' => 'required',
            'category_id' => 'integer'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $createSubCategoryResponse = $this->subCategoryService->create(
            $request->name,
            $request->category_id
        );
        if (!$createSubCategoryResponse['success']) {

            return response()->json([
                'success' => $createSubCategoryResponse['success'],
                'message' => $createSubCategoryResponse['message']
            ]);
        }

        return response()->json([
            'success' => $createSubCategoryResponse['success'],
            'message' => $createSubCategoryResponse['message']
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editSubCategory (Request $request) {
        try {
            $subCategory = $this->subCategoryService->subCategory($request->id);
            if (!$subCategory['success']) {

                return response()->json([
                    'success' => $subCategory['success'],
                    'error' => $subCategory['message']
                ]);
            }
            $data = $subCategory['data'];

            return response()->json([
                'success' => $subCategory['success'],
                'message' => $subCategory['message'],
                'data' => $data
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => $subCategory['success'],
                'error' => $subCategory['message']
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     */
    public function updateSubCategory(Request $request) {
        $rules = [
            'name' => 'required',
            'id' => 'integer',
            'category_id' => 'integer'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $updateSubCategoryResponse = $this->subCategoryService->update(
            $request->id,
            $request->name,
            $request->category_id
        );
        if (!$updateSubCategoryResponse['success']) {

            return redirect()->back()->with('error', $updateSubCategoryResponse['message']);
        }

        return response()->json([
            'success' => $updateSubCategoryResponse['success'],
            'message' => $updateSubCategoryResponse['message']
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteSubCategory(Request $request) {
        $rules = ['id' => 'integer'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $deleteSubCategoryResponse = $this->subCategoryService->delete($request->id);
        if (!$deleteSubCategoryResponse['success']) {

            return response()->json([
                'error' => $deleteSubCategoryResponse['message'],
            ]);
        }

        return response()->json([
            'success' => $deleteSubCategoryResponse['success'],
            'message' => $deleteSubCategoryResponse['message']
        ]);
    }
}
