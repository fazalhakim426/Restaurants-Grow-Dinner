<?php

namespace App\Http\Controllers;

use App\Employee; 
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\FinanceResource;
use App\User;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{ 
    public function index()
    {
        $employee = Employee::all();

        return response()->json([
            "success" => true,
            "message" => "Employee List",
            "data" =>  FinanceResource::collection($employee)
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        $data = $request->all();
  
        $fileName = time().'.'.$request->documents->extension();  
        $request->documents->move(public_path('uploads/employee'), $fileName); 
        $data['documents'] = 'uploads/employee/'.$fileName;    
        $data['password'] =  Hash::make($request->password);    

        $employee = Employee::create($data);
        $data['userable_type']='App\Employee';
        $data['userable_id'] = $employee->id;

         $employee->user()->save(User::create($data));

        return response()->json([
            "success" => true,
            "message" => "Employee created successfully.",
            "data" => new EmployeeResource($employee), 
        ], 201);
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee)
    { 
  
        $employee->update($request->all()); 
        $user = $employee->user;
        $user->update($request->all());

        if($request->documents){  
            $fileName = time().'.'.$request->documents->extension();  
            $request->documents->move(public_path('uploads/employee'),$fileName);  
            $employee->update(['documents'=>'uploads/employee/'.$fileName]);    

        }
        if($request->password){ 
            $employee->user->update(['password' => Hash::make($request->password)]);
        }

        $employee->refresh();  
        return response()->json([
            "success" => true,
            "message" => "Updated successfully.",
            "data" =>new FinanceResource($employee)
        ]);
 
    }

    public function show($id)
    {
     
        $employee = Employee::find($id);
             
        if (is_null($employee)) {
            return response()->json([
                "success" => false,
                "message" => "Employee not Found!"
            ],401);
        }
        return response()->json([
            "success" => true,
            "message" => "Employee retrieved successfully.",
            "data" => new EmployeeResource($employee)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $employee = Employee::find($id);
        if($employee){
            $employee->user->delete();
            $employee->delete();
            return response()->json([
                "success" => true,
                "message" => "Employee deleted successfully."
            ]);
        }else{
            return response()->json([
                "success" => false,
                "message" => "Employee not found."
            ]);
        }

       
    }
}
