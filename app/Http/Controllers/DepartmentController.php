<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $department = Department::create([
            'name' => $request->name
        ]);

        return response()->json([
            'id' => $department->id,
            'name' => $department->name,
            'status' => 'success'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $department = Department::findOrFail($id);
        $department->update([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'success',
            'id' => $department->id,
            'name' => $department->name
        ]);
    }

    public function destroy($id)
    {
        Department::findOrFail($id)->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}