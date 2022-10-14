<?php
/**
* Class and Function List:
* Function list:
* - index()
* - create()
* - store()
* - show()
* - edit()
* - update()
* - destroy()
* Classes list:
* - DepartmentController extends Controller
*/
namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;
use Session;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = department::all();
        return view('department.department', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('department.department_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $department       = new department;
        $department->name = $request->name;
        $department->save();

        Session::flash('status', 1);
        return redirect('/department');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(department $department)
    {
        return view('department.department_edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $department       = department::find($request->id);
        $department->name = $request->name;
        $department->save();

        Session::flash('status', 1);
        return redirect('/department');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd('delete');
        department::find($id)->delete();
        Session::flash('status', 3);
        return redirect()
            ->back();
    }
}

