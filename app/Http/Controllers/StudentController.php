<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Fetch all students (Read)
    public function index()
    {
        return response()->json(Student::all());
    }

    // Store a new student (Create)
    public function store(Request $request)
    {
        // Check if ID already exists
        if (Student::where('id', $request->id)->exists()) {
            return response()->json(['error' => 'Student ID already exists'], 400);
        }

        $student = Student::create($request->all());
        return response()->json($student);
    }

    // Update an existing student (Update)
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->update($request->all());
            return response()->json($student);
        } else {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    // Delete a student (Delete)
    public function destroy($id)
    {
        Student::destroy($id);
        return response()->json(['success' => 'Record deleted successfully']);
    }
}