<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Enrollment;

class ClassroomController extends Controller
{
    public function create(Request $request)
    {
        $validatedClassroom = Validator::make(
            $request->all(),
            [
                'teacher_id' => 'required',
                'name' => 'required',
                'grade' => 'required'
            ]
        );
        if ($validatedClassroom->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedClassroom->errors()
            ], 401);
        }
        $classroom = Classroom::create([
            'teacher_id' => $request->teacher_id,
            'name' => $request->name,
            'grade' => $request->grade


        ]);
        return response()->json([
            'status' => true,
            'message' => 'Classroom Created successfully'

        ], 200);
    }
    public function index()
    {
        $classrooms = Classroom::all();
        return response()->json([
            'status' => true,
            'data' => $classrooms
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $classroom = Classroom::find($id);

        if (!$classroom) {
            return response()->json([
                'status' => false,
                'message' => 'Classroom not found'
            ], 404);
        }

        $validatedClassroom = Validator::make(
            $request->all(),
            [
                'name' => 'sometimes|required',
                'created_by' => 'sometimes|required',
            ]
        );

        if ($validatedClassroom->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedClassroom->errors()
            ], 401);
        }

        $classroom->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Classroom updated successfully',
            'data' => $classroom
        ], 200);
    }

    // Delete a classroom
    public function delete($id)
    {
        $classroom = Classroom::find($id);

        if (!$classroom) {
            return response()->json([
                'status' => false,
                'message' => 'Classroom not found'
            ], 404);
        }

        $classroom->delete();

        return response()->json([
            'status' => true,
            'message' => 'Classroom deleted successfully'
        ], 200);
    }
    public function getbyid($id)
    {
        $classroom = Classroom::find($id);
        if (!$classroom) {
            return response()->json([
                'status' => false,
                'message' => 'Classroom not Found!',
            ], 404);

        }
        return response()->json(
            [
                'status' => true,
                'data' => $classroom

            ],
            200

        );
    }
}
