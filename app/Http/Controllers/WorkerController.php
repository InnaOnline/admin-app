<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DataTableCollectionResource
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        /** @var Builder $query */
        $query = Worker::with('departments:name')->eloquentQuery($orderBy, $orderByDir, $searchValue);

        $salaryGt = $request->input('salaryGt');
        $salaryLt = $request->input('salaryLt');
        if (isset($salaryGt)) {
            $query->where("salary", ">=", $salaryGt);
        }
        if (isset($salaryLt)) {
            $query->where("salary", "<=", $salaryLt);
        }

        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);

//
//        $workers=Worker::all();
//        return response()->json($workers);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
//        dd($request->all(), $request->name);
        $validator=Validator::make($request->all(),
            [
            'name' => 'required|min:3|max:255',
            'salary' => 'required|integer|min:1000',
            'departments' => 'array'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        $worker=new Worker();
        $worker->name=$request->name;
        $worker->salary=$request->salary;
        $worker->save();
        $worker->departments()->attach($request->departments);
        return response()->json([
            'id' => $worker->id,
            'name' => $worker->name,
            'salary' => $worker->salary,
            'departments' => $worker->departments,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $worker=Worker::findOrFail($id);
        return response()->json([
            'id' => $worker->id,
            'name' => $worker->name,
            'salary' => $worker->salary,
            'departments' => $worker->departments,
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
                'salary' => 'required|integer|min:1000',
                'departments' => 'array'
            ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        $worker=Worker::findOrFail($id);
        $worker->name=$request->name;
        $worker->salary=$request->salary;
        $worker->save();
        $worker->departments()->attach($request->departments);
        return response()->json([
            'id' => $worker->id,
            'name' => $worker->name,
            'salary' => $worker->salary,
            'departments' => $worker->departments,
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
        $worker=Worker::findOrFail($id);
        $worker->delete();
        return response()->json([]);
    }
}
