<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function create(Request $request)
    {
        $validatedSubject = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validatedSubject->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedSubject->errors()
            ], 401);
        }

        $subject = Subject::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subject Created successfully'
        ], 200);
    }

    public function index()
    {
        $subjects = Subject::all();
        return response()->json([
            'status' => true,
            'data' => $subjects
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::find($id);
        if (!$subject) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not Found'
            ], 404);
        }

        $validatedSubject = Validator::make($request->all(), [
            'name' => 'sometimes|required'
        ]);

        if ($validatedSubject->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedSubject->errors()
            ], 401);
        }

        $subject->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Subject updated successfully',
            'data' => $subject
        ], 200);
    }

    public function delete($id)
    {
        $Subject = Subject::find($id);
        if (!$Subject) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not Found'
            ], 404);
        }

        $Subject->delete();
        return response()->json([
            'status' => true,
            'message' => 'Grade was Deleted'
        ], 200);
    }
    
}
