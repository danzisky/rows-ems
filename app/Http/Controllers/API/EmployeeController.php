<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    private $cacheKey = 'last_modification_employees';

    private function updateCacheTracker()
    {
        Cache::put($this->cacheKey, now(), now()->addMinutes(120));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cacheKey = 'employees_' . md5(json_encode([
            'search' => $request->get('search'),
            'min_salary' => $request->get('min_salary'),
            'max_salary' => $request->get('max_salary'),
            'sort_by' => $request->get('sort_by'),
            'order' => $request->get('order', 'asc'),
            'page' => $request->get('page', 1)
        ]));

        $cacheDuration = now()->addMinutes(120);

        if (Cache::get($this->cacheKey) > now()->subMinutes(120)) { // if a change has been made in the last 120 minutes
            $this->updateCacheTracker();
            cache()->forget($cacheKey);
        }
        $employees = Cache::remember($cacheKey, $cacheDuration, function () use ($request) {
            $query = Employee::query();

            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->filled('min_salary') && $request->filled('max_salary')) {
                $query->whereBetween('salary', [$request->min_salary, $request->max_salary]);
            }

            if ($request->filled('sort_by')) {
                $query->orderBy($request->sort_by, $request->get('order', 'asc'));
            }

            return $query->paginate(6);
        });

        return response()->json($employees); // Return the employees in JSON format
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

            $this->updateCacheTracker();

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

            $this->updateCacheTracker();

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
