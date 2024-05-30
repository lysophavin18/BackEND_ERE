<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    public function create(Request $request)
    {
        $validatedGrade = Validator::make($request->all(), [
            'value' => 'required'
        ]);

        if ($validatedGrade->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedGrade->errors()
            ], 401);
        }

        $grade = Grade::create([
            'value' => $request->value,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Grade Created successfully'
        ], 200);
    }

    public function index()
    {
        $grades = Grade::all();
        return response()->json([
            'status' => true,
            'data' => $grades
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $grade = Grade::find($id);
        if (!$grade) {
            return response()->json([
                'status' => false,
                'message' => 'Grade not Found'
            ], 404);
        }

        $validatedGrade = Validator::make($request->all(), [
            'value' => 'sometimes|required'
        ]);

        if ($validatedGrade->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedGrade->errors()
            ], 401);
        }

        $grade->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Grade updated successfully',
            'data' => $grade
        ], 200);
    }

    public function delete($id)
    {
        $grade = Grade::find($id);
        if (!$grade) {
            return response()->json([
                'status' => false,
                'message' => 'Grade not Found'
            ], 404);
        }

        $grade->delete();
        return response()->json([
            'status' => true,
            'message' => 'Grade was Deleted'
        ], 200);
    }
}
