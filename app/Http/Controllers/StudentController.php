<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validatorStudent = Validator::make(
                $request->all(),
                [

                    "name" => "required|string|max:255",
                    "email" => "required|string|email|max:255|unique:teachers",
                    "password" => "required",
                    "gender" => "required|string",
                    "role" => "required|string ",
                ]
            );

            if ($validatorStudent->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validatorStudent->errors()
                ], 401);
            }
            $student = Student::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'gender' => $request->gender,
                    'role' => $request->role,
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Student has Created',
                'token' => $student->createToken('API TOKEN')->plainTextToken,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);

        }

    }
    public function login(Request $request)
    {
        try {
            $validatorStudent = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'

                ]
            );
            if ($validatorStudent->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'erorrs' => $validatorStudent->errors(),
                ], 401);
            }


            $student = Student::where('email', $request->email)->first();
            if (!$student || Hash::check($request->password, $student->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email $ Password do not match with our record'
                ], 401);
            }
            response()->json([
                'status' => true,
                'message' => 'Login successfully',
                'token' => $student->createToken('API TOKEN ')->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        try {
            if ($request->user()) {
                $request->user()->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Logout Successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'No authenticated user found ',
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function profile(Request $request)
    {
        try {
            $student = $request->user();
            return response()->json([
                'status' => true,
                'data ' => [
                    'id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                    'password' => $student->password,
                    'role' => $student->role

                ],
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);

        }
    }
}