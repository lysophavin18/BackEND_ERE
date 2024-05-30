<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Subject_Item;
use App\Models\Subject;
use App\Models\Classroom;

class Subject_ItemController extends Controller
{
    public function index()
    {
        $subject_items = Subject_Item::all();
        return response()->json([
            'status' => true,
            'data' => $subject_items
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            'max_score' => 'required',
            'passing_score' => 'required',
            'subject_id' => 'required',
            'classroom_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 401);
        }

        $subject_item = Subject_Item::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Subject Item created successfully',
            'data' => $subject_item,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $subject_item = Subject_Item::find($id);
        if (!$subject_item) {
            return response()->json([
                'status' => false,
                'message' => 'Subject Item not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            "name" => "required",
            'max_score' => 'required',
            'passing_score' => 'required',
            'subject_id' => 'required',
            'classroom_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 401);
        }

        $subject_item->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Subject Item updated successfully',
            'data' => $subject_item,
        ], 200);
    }

    public function delete($id)
    {
        $subject_item = Subject_Item::find($id);
        if (!$subject_item) {
            return response()->json([
                'status' => false,
                'message' => 'Subject Item not found',
            ], 404);
        }

        $subject_item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Subject Item deleted successfully',
        ], 200);
    }
    public function getbyid($id)
    {
        $subject_item = Subject_Item::find($id);
        $subject = Subject::find($subject_item->subject_id);
        $subject_item->subject = $subject->name;
        $classroom = Classroom::find($subject_item->classroom_id);
        $subject_item->classroom_id = $classroom->name;
        return response()->json([
            'status' => true,
            'data' => $subject_item

        ]);
    }
}
