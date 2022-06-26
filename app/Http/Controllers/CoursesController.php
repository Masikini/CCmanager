<?php

namespace App\Http\Controllers;

use App\Courses;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
          $courses = Courses::all();
          return $courses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $newCourse = new Courses;
       $newCourse->name = $request->course["name"];
       $newCourse->fee = $request->course["fee"];
       $newCourse->description = $request->course["description"];
       $newCourse->id_no = $request->course["id_no"];

       $newCourse->save();

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function show(Courses $courses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function edit(Courses $courses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $editCourse = new Courses;
        $courseData = json_decode($request->course);
        $editCourse = Courses::firstWhere('id_no', $courseData->id_no);

        if ($editCourse) {

            $editCourse->id_no =  $courseData->id_no;
            $editCourse->name =  $courseData->name;
            $editCourse->description = $courseData->description;
            $editCourse->fee = $courseData->fee;

            $editCourse->save();
            return 'True';
        } else {
            return 'False';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteCourse = Courses::firstWhere('id_no', $id);
        $deleteCourse->delete();
    }
}
