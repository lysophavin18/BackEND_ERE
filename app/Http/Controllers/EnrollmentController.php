<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::all();
        return response()->json([
            'status' => true,
            'data' => $enrollments
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|integer',
            'classroom_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $enrollment = Enrollment::create($request->only('student_id', 'classroom_id'));

        return response()->json([
            'status' => true,
            'message' => 'Enrollment created successfully',
            'data' => $enrollment
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json([
                'status' => false,
                'message' => 'Enrollment not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'student_id' => 'sometimes|required|integer',
            'classroom_id' => 'sometimes|required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $enrollment->update($request->only('student_id', 'classroom_id'));

        return response()->json([
            'status' => true,
            'message' => 'Enrollment updated successfully',
            'data' => $enrollment
        ], 200);
    }

    public function delete($id)
    {
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json([
                'status' => false,
                'message' => 'Enrollment not found'
            ], 404);
        }

        $enrollment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Enrollment deleted successfully'
        ], 200);
    }
    public function getbyid($id)
    {
        $enrollment = Enrollment::find($id);
        if (!$enrollment) {
            return response()->json([
                'status' => false,
                'message' => 'Enrollment not found !'
            ], 404);
        }

        $classroom = Classroom::find($id);
        if (!$classroom) {
            return response()->json([
                'status' => false,
                'message' => 'Classroom not Found!'
            ], 404);
        }
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Student Not Found!'
            ], 404);
        }

        $reponse = [
            ' enrollment' => $enrollment,
            'classroom' => $classroom->name,
            'student' => $student->name,
        ];
        return response()->json([
            'status' => true,
            'data' => $reponse,
        ], 200);

    }
}
