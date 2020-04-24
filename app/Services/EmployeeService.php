<?php


namespace App\Services;


use App\Models\Employee;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class EmployeeService
{
    protected $errorResponse;
    /**
     * EmployeeService constructor.
     */
    public function __construct() {
        $this->errorResponse = [
            'success' => true,
            'message' =>'something went wrong'
        ];
    }

    /**
     * @return Employee[]|Collection
     */
    public function getAllEmployee () {
        $shopId = Shop::where('user_id', Auth::id())->first()->id;
        $allEmployee = Shop::find ($shopId)->employees;
        if(!$allEmployee->isEmpty()){

            return ['success' => true, 'data' => $allEmployee];
        }

        return ['success' => false, 'data' => null];
    }

    /**
     * @param int $employeeId
     * @return array
     */
    public function employee (int $employeeId) :array{
        try {
            $employee = Employee::find($employeeId);
            if (is_null($employee)) {

                return ['success' => false, 'message' => 'employee is not found'];
            }

            return ['success' => true, 'message' => 'employee is found', 'data' => $employee];
        } catch (\Exception $e) {

            return ['success'=>false,'message'=>[$e->getMessage()]];
        }
    }

    /**
     * @param int $shopId
     * @param string $employeeName
     * @param bool $stillWorking
     * @param int $salary
     * @param string $startedAt
     * @param string $endedAt
     * @return array
     */
    public function create (string $employeeName, bool $stillWorking, int $salary , string $startedAt, string $endedAt) {
        $shopId = Shop::where('user_id', Auth::id())->first()->id;
        try {
           $createEmployeeResponse = Employee::create([
               'shop_id' => $shopId,
               'name' => $employeeName,
               'still_working' => $stillWorking,
               'salary' => $salary,
               'started_at' => $startedAt,
               'ended_at' => $endedAt
           ]);
            if (!$createEmployeeResponse) {

                return $this->errorResponse;
            }

            return ['success' => true, 'message' => 'employee has been created successfully'];
        } catch (\Exception $e) {

            return ['success'=>false,'message'=>[$e->getMessage()]];
        }
    }

    /**
     * @param int $employeeId
     * @param int $shopId
     * @param string $employeeName
     * @param bool $stillWorking
     * @param int $salary
     * @param string $startedAt
     * @param string $endedAt
     * @return array
     */
    public function update (int $employeeId, int $shopId, string $employeeName, bool $stillWorking, int $salary , string $startedAt, string $endedAt) :array{
        try {
            $updateEmployeeResponse = Employee::where('id', $employeeId)->update([
                'shop_id' => $shopId,
                'name' => $employeeName,
                'still_working' => $stillWorking,
                'salary' => $salary,
                'started_at' => $startedAt,
                'ended_at' => $endedAt
            ]);
            if (!$updateEmployeeResponse) {

                return $this->errorResponse;
            }

            return ['success' => true, 'message' => 'employee has been updated successfully'];
        } catch (\Exception $e) {

            return ['success'=>false,'message'=>[$e->getMessage()]];
        }
    }

    /**
     * @param int $employeeId
     * @return array
     */
    public function delete (int $employeeId) :array{
        try {
            $deleteEmployeeResponse = Employee::where('id', $employeeId)->delete();
            if (!$deleteEmployeeResponse) {

                return $this->errorResponse;
            }

            return ['success' => true, 'message' => 'employee has been deleted successfully'];
        } catch (\Exception $e) {

            return $this->errorResponse;
        }
    }
}
