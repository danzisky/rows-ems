<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = Employee::query();

        if ($request->filled('search')) {
            $employees->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sort_by')) {
            $employees->orderBy($request->sort_by, $request->get('order', 'asc'));
        }

        $employees = $employees->paginate(6);

        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::create($request->all());

            if ($request->filled('certifications')) {
                $employee->certifications()->attach($request->certifications);
            }

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            dd($e->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while creating the employee'], 500);
        }

        return response()->json(['message' => 'Employee created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load('certifications');
        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        DB::beginTransaction();
        try {
            $employee->update($request->all());

            if ($request->filled('certifications')) {
                $employee->certifications()->sync($request->certifications);
            }

            DB::commit();

        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while updating the employee'], 500);
        }

        return response()->json(['message' => 'Employee updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the employee'], 500);
        }

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
