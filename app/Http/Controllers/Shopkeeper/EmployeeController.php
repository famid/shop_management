<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Shop;
use App\Services\EmployeeService;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    protected $employeeService;

    /**
     * EmployeeController constructor.
     */
    public function __construct () {
        $this->employeeService = new EmployeeService();
    }

    /**
     * @return Factory|View
     */
    public function createEmployee () {

        return view('shopkeeper.employee.employee');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeEmployee(Request $request) {
       $rules = [
            'name' => 'string',
            'salary' => 'integer',
            'still_working' => 'boolean',
            'started_at' => 'required|date|date_format:Y-m-d',
            'ended_at' => 'required|date|date_format:Y-m-d',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        $startedAt = Carbon::parse($request->started_at);
        $endedAt = Carbon::parse($request->ended_at);
        $createEmployeeResponse = $this->employeeService->create(
            $request->name,
            $request->still_working,
            $request->salary,
            $startedAt,
            $endedAt
        );

        $success = $createEmployeeResponse['success'] ? true : false;
        $message = $createEmployeeResponse['success'] ? $createEmployeeResponse['message'] : 'something went wrong';

        return  response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getEmployeeList () {
        $getAllEmployeeResponse = $this->employeeService->getAllEmployee();
        $success = $getAllEmployeeResponse['success'] ? true:false;
        $allEmployee = $getAllEmployeeResponse['success'] ? $getAllEmployeeResponse['data']:'';

        return response()->json(['success' => $success, 'allEmployee' => $allEmployee]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteEmployee (Request $request) {
        $rules = ['id' => 'required|integer'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        $deleteEmployeeResponse = $this->employeeService->delete($request->id);
        if (!$deleteEmployeeResponse['success']) {

            return response()->json(['success' => false, 'message' => $deleteEmployeeResponse['message']]);
        }

        return response()->json(['success' => true, 'message' => $deleteEmployeeResponse['message']]);
    }

    public function updateEmployee(Request $request) {
        $rules = [
            'id' => 'integer',
            'shop_id' => 'integer',
            'name' => 'string',
            'salary' => 'integer',
            'still_working' => 'boolean',
            'started_at' => 'required|date|date_format:Y-m-d',
            'ended_at' => 'required|date|date_format:Y-m-d',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        $startedAt = Carbon::parse($request->started_at);
        $endedAt = Carbon::parse($request->ended_at);
        $updateEmployeeResponse = $this->employeeService->update(
            $request->id,
            $request->shop_id,
            $request->name,
            $request->still_working,
            $request->salary,
            $startedAt,
            $endedAt
        );

        $success = $updateEmployeeResponse['success'] ? true : false;
        $message = $updateEmployeeResponse['success'] ? $updateEmployeeResponse['message'] : 'something went wrong';

        return  response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
    public function getModalData (Request $request) {

        $employData= $this->employeeService->employee($request->id);
        $getModalData = $employData['data'];
        return response()->json([
            'getModalData' => $getModalData
        ]);
    }
}
