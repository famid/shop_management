<?php


namespace App\Services;


class EmployeeService
{
    /**
     * EmployeeService constructor.
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
    public function getAllEmployee () :array{

    }

    /**
     * @param int $employeeId
     * @return array
     */
    public function employee (int $employeeId) :array{
        try{

        } catch (\Exception $e){

        }
    }

    /**
     * @param string $employeeName
     * @param bool $stillWorking
     * @param int $salary
     * @param string $startedAt
     * @param string $endedAt
     * @return array
     */
    public function create (string $employeeName, bool $stillWorking, int $salary , string $startedAt, string $endedAt) :array{
        try{

        } catch (\Exception $e){

        }
    }

    /**
     * @param int $employeeId
     * @param string $employeeName
     * @param bool $stillWorking
     * @param int $salary
     * @param string $startedAt
     * @param string $endedAt
     * @return array
     */
    public function update (int $employeeId, string $employeeName, bool $stillWorking, int $salary , string $startedAt, string $endedAt) :array{
        try{

        } catch (\Exception $e){

        }
    }

    /**
     * @param int $employeeId
     * @return array
     */
    public function delete (int $employeeId) :array{

    }
}
