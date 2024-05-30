<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    // Create teacher
    public function create(Request $request)
    {
        try {
            $validatedTeacher = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:teachers',
                    'password' => 'required|string|min:6',
                    'gender' => 'required|string',
                    'role' => 'required|string'
                ]
            );

            if ($validatedTeacher->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validatedTeacher->errors(),
                ], 401);
            }

            $teacher = Teacher::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'role' => $request->role
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Teacher created successfully',
                'token' => $teacher->createToken('API TOKEN')->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    // Teacher login
    public function teacherlogin(Request $request)
    {
        try {
            // Validate the input data
            $validatedTeacher = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            // Check if validation fails
            if ($validatedTeacher->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validatedTeacher->errors(),
                ], 401);
            }

            // Retrieve the teacher by email
            $teacher = Teacher::where('email', $request->email)->first();

            // Check if teacher exists and the password is correct
            if (!$teacher || !Hash::check($request->password, $teacher->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password do not match with our records.',
                ], 401);
            }

            // Generate an API token for the teacher
            return response()->json([
                'status' => true,
                'message' => 'Login successfully',
                'token' => $teacher->createToken('API TOKEN')->plainTextToken,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }


    public function teacher_logout(Request $request)
    {
        try {
            // Check if the user is authenticated
            if ($request->user()) {
                // Revoke all tokens for the authenticated teacher
                $request->user()->tokens()->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Logout successfully',
                ], 200);
            } else {
                // If no user is authenticated, return an error response
                return response()->json([
                    'status' => false,
                    'message' => 'No authenticated user found',
                ], 401);
            }
        } catch (\Throwable $th) {
            // Handle any exceptions that may occur
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    public function profile(Request $request)
    {
        try {
            // Retrieve the authenticated teacher using the token
            $teacher = $request->user();

            // If the teacher is found, return the profile data
            return response()->json([
                'status' => true,
                'data' => [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                    'email' => $teacher->email,
                    'gender' => $teacher->gender,
                    'role' => $teacher->role,
                    // Add other fields as needed
                ],
            ], 200);
        } catch (\Throwable $th) {
            // Handle exceptions
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }





}