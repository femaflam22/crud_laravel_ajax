<?php

namespace App\Http\Controllers;

use App\Models\Student;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function view()
    {
        return view('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = Student::all();

        return $request->ajax() ? response()->json($companies,200) : abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Student::updateOrCreate(
            [
              'id' => $request->id
            ],
            [
              'nis' => $request->nis,
              'nama' => $request->nama,
              'rombel' => $request->rombel,
              'rayon' => $request->rayon,
            ]
        );
      
        return response()->json(
            [
              'code' => 200,
              'message' => 'Data berhasil disimpan!'
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student  = Student::find($id);

        return response()->json([
            'data' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        $student->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
