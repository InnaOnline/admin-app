<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Models\Department;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $departments=Department::all();
        return response()->json($departments);
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
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'name' => 'required|min:3|max:255',
                'started_at' => 'required|date_format:Y-m-d',
                'workers' => 'array'
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        $department=new Department();
        $department->name=$request->name;
        $department->started_at=new Carbon($request->started_at);
        $department->save();
//        $department->workers()->attach([1,2]);
        return response()->json([
            'id' => $department->id,
            'name' => $department->name,
            'started_at' => $department->started_at,
            'workers' => $department->workers,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $department=Department::findOrFail($id);
        return response()->json([
            'id' => $department->id,
            'name' => $department->name,
            'started_at' => $department->started_at,
            'workers' => $department->workers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(),
            [
                'name' => 'required|min:3|max:255',
                'started_at' => 'required|date_format:Y-m-d',
                'workers' => 'array'
            ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        $department=Department::findOrFail($id);
        $department->name=$request->name;
        $department->started_at=new Carbon($request->started_at);
        $department->save();
        $department->workers()->attach($request->workers);
        return response()->json([
            'id' => $department->id,
            'name' => $department->name,
            'started_at' => $department->started_at,
            'workers' => $department->workers,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function destroy(int $id)
    {
        $department=Department::findOrFail($id);
        $department->delete();
        return response()->json([]);
    }
}
