<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')->get();
        $departments = Department::all();

        return view('dashboard', compact('employees', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'department_id' => 'required'
        ]);

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'department_id' => $request->department_id
        ]);

        return response()->json([
            'id' => $employee->id,
            'name' => $employee->name,
            'email' => $employee->email,
            'position' => $employee->position,
            'department_id' => $employee->department_id,
            'status' => 'success'
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'department_id' => 'required'
        ]);

        $employee = Employee::findOrFail($id);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'department_id' => $request->department_id
        ]);

        return response()->json([
            'status' => 'success',
            'id' => $employee->id,
            'name' => $employee->name,
            'email' => $employee->email,
            'position' => $employee->position,
            'department_id' => $employee->department_id
        ]);
    }

    // DELETE (AJAX)
    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
