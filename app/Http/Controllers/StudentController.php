<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.index');
    }


    public function fetchstudent(Request $request)
    {
        $phone = $request->input('phone');
        
        if ($phone) {
            // Recherche de l'étudiant par numéro de téléphone
            $student = Student::where('phone', $phone)->first();

            if (!$student) {
                // Appel à `store` avec le numéro de téléphone
                return $this->store($request);
            }

            return response()->json([
                'students' => $student ? [$student] : [],
            ]);
        } else {
            $students = Student::all();
            return response()->json([
                'students' => $students,
            ]);
        }
    }





    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'nullable|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'required|max:191',
            'course' => 'nullable|max:191'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $student = new Student;

            $student->name = $request->input('name') !== "" ? $request->input('name') : null;
            $student->email = $request->input('email') !== "" ? $request->input('email') : null;
            $student->phone = $request->input('phone'); // Ce champ est requis, donc pas besoin de vérification
            $student->course = $request->input('course') !== "" ? $request->input('course') : null;

            $student->save();


            return response()->json([
                'status' => 200,
                'message' => 'Student Added Succesfully'
            ]);
        }
    }

    public function edit($id)
    {
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                'status' => 200,
                'student' => $student,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'student not found'
            ]);
        }
    }


    public function update(Request $request, $id)

    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'required|max:191',
            'course' => 'nullable|max:191'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $student = Student::find($id);

            if ($student) {

                $student->name = $request->input('name') !== "" ? $request->input('name') : null;
                $student->email = $request->input('email') !== "" ? $request->input('email') : null;
                $student->phone = $request->input('phone'); // Ce champ est requis, donc pas besoin de vérification
                $student->course = $request->input('course') !== "" ? $request->input('course') : null;

                $student->update();


                return response()->json([
                    'status' => 200,
                    'message' => 'Student updated Succesfully'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'student not found'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $student=Student::find($id);
        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => 'student deleted succesfully',
        ]);
    }
}
