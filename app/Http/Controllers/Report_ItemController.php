<?php

namespace App\Http\Controllers;

use App\Models\Report_Item;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Subject_Item;
use Illuminate\Support\Facades\Validator;
use App\Models\Grade;

class Report_ItemController extends Controller
{
    public function create(Request $request)
    {
        $validatedReport_Item = Validator::make($request->all(), [
            "report_id" => "required",
            'subjectitem_id' => 'required',
            'score' => 'required',
            'grade_id' => 'required',
        ]);

        if ($validatedReport_Item->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedReport_Item->errors()
            ], 401);
        }

        $Report_Item = Report_Item::create([
            'report_id' => $request->report_id,
            'subjectitem_id' => $request->subjectitem_id,
            'score' => $request->score,
            'grade_id' => $request->grade_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Report_Item Created successfully'
        ], 200);
    }

    public function index()
    {
        $report_items = Report_Item::all();
        return response()->json([
            'status' => true,
            'data' => $report_items
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $report_item = Report_Item::find($id);
        if (!$report_item) {
            return response()->json([
                'status' => false,
                'message' => 'Report_Item not Found'
            ], 404);
        }

        $validatedReport_Item = Validator::make($request->all(), [
            'subjectitem_id' => 'sometimes|required'
        ]);

        if ($validatedReport_Item->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedReport_Item->errors()
            ], 401);
        }

        $report_item->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Report_Item updated successfully',
            'data' => $report_item
        ], 200);
    }

    public function delete($id)
    {
        $report_item = Report_Item::find($id);
        if (!$report_item) {
            return response()->json([
                'status' => false,
                'message' => 'Report_Item not Found'
            ], 404);
        }

        $report_item->delete();
        return response()->json([
            'status' => true,
            'message' => 'Report_Item was Deleted'
        ], 200);
    }
    public function getbyid($id)
    {
        $report_item = Report_Item::find($id);
        $subject_item = Subject_Item::find($report_item->subjectitem_id);
        $report_item->subject_item = $subject_item->name;

        $grade = Grade::find($report_item->grade_id);
        $report_item->grade_id = $grade->value;


        return response()->json([
            'status' => true,
            'data' => $report_item
        ]);
    }

}
