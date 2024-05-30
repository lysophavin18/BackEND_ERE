<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Month;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Report_Item;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        $validatedReport = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'report_item_is' => 'report_item_id',
            'classroom_id' => 'required|exists:classrooms,id',
            'month_id' => 'required|date_format:Y-m',
            'issued_by' => 'required|integer',
            'updated_by' => 'nullable|integer',
            'accepted' => 'required|boolean',
            'teacher_cmt' => 'nullable|string',
            'parent_cmt' => 'nullable|string',
            'is_sent' => 'required|boolean',
            'total_score' => 'required|integer',
            'abs' => 'required|integer',
            'permission' => 'required|integer',
            'issued_at' => 'required|date'
        ]);

        if ($validatedReport->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedReport->errors()
            ], 401);
        }

        $report = Report::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Report Created successfully',
            'data' => $report
        ], 200);
    }

    public function index()
    {
        $reports = Report::all();
        return response()->json([
            'status' => true,
            'data' => $reports
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $report = Report::find($id);
        if (!$report) {
            return response()->json([
                'status' => false,
                'message' => 'Report not found'
            ], 404);
        }

        $validatedReport = Validator::make($request->all(), [
            'student_id' => 'required',
            'report_item_id' => 'required',
            'classroom_id' => 'required,',
            'month_id' => 'sometimes|',
            'issued_by' => 'sometimes|required|integer',
            'updated_by' => 'sometimes|nullable|integer',
            'accepted' => 'sometimes|required|boolean',
            'teacher_cmt' => 'sometimes|nullable|string',
            'parent_cmt' => 'sometimes|nullable|string',
            'is_sent' => 'sometimes|required|boolean',
            'total_score' => 'sometimes|required|integer',
            'abs' => 'sometimes|required|integer',
            'permission' => 'sometimes|required|integer',
            'issued_at' => 'sometimes|required|date'

        ]);
        $report->save();

        if ($validatedReport->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedReport->errors()
            ], 401);
        }

        $report->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Report updated successfully',
            'data' => $report
        ], 200);
    }

    public function delete($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return response()->json([
                'status' => false,
                'message' => 'Report not found'
            ], 404);
        }

        $report->delete();

        return response()->json([
            'status' => true,
            'message' => 'Report was deleted'
        ], 200);
    }


    public function getById($id)
    {
        // Retrieve the report by ID
        $report = Report::find($id);

        if (!$report) {
            return response()->json([
                'status' => false,
                'message' => 'Report not found',
            ], 404);
        }

        // Retrieve the associated report items
        $report_items = Report_Item::find($report->report_item_id);

        // Retrieve the associated classroom
        $classroom = Classroom::find($report->classroom_id);

        if (!$classroom) {
            return response()->json([
                'status' => false,
                'message' => 'Classroom not found',
            ], 404);
        }
        $month = Month::find($report->month_id);
        if (!$month) {
            return response()->json([
                'status' => false,
                'message' => 'Month not Found',
            ], 404);
        }

        // Structure the response data
        $response = [
            'report' => $report,
            'report_items' => $report_items->id,
            'classroom' => $classroom->name,
            'month' => $month->value
        ];

        return response()->json([
            'status' => true,
            'data' => $response,
        ], 200);
    }

}
