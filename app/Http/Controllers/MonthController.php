<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Month;
use Illuminate\Http\Request;

class MonthController extends Controller
{



    public function index()
    {
        $months = Month::all();
        return response()->json([
            'status' => true,
            'data' => $months
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|date_format:Y-m'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }

        $month = Month::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Month created successfully',
            'data' => $month
        ], 200);
    }

    public function delete($id)
    {
        $month = Month::find($id);
        if (!$month) {
            return response()->json([
                'status' => false,
                'message' => 'Month not found'
            ], 404);
        }

        $month->delete();

        return response()->json([
            'status' => true,
            'message' => 'Month deleted successfully'
        ], 200);
    }
}


