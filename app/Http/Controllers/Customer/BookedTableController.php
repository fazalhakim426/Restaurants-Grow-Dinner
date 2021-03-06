<?php

namespace App\Http\Controllers\Customer;

use App\BookedTable;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookedTableResource;
use App\Restaurant;
use App\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookedTableController extends Controller
{
     public function restaurant_booking($id)
     {
         $restaurant = Restaurant::find($id);

         return response()->json([
             'data' => BookedTableResource::collection($restaurant->bookedTables()->with('customer.user')->get()),
         ]);
     }
      public function index()
      {
          $auth_user = Auth::user();
          $customer =  $auth_user->userable;
          $booked_table = $customer->bookedTable()->with('restaurant')->with('restaurant.reviews')->get(); 
          return response()->json([
              'success' => true,
              'message' => 'Booked Table',
               'data' =>  BookedTableResource::collection($booked_table) 
          ]); 
      }

    public function bookedSlots($table,$date)
    {  
        $bookedTables = $table->bookedTables()->where('date',$date)->get(); 
        $bookedSlots = array();
        foreach($bookedTables as $bookedTable){
           array_push($bookedSlots, $bookedTable->time_slot);
        } 
        return $bookedSlots;
    }

    public function availableTimeSlots($table,$date)
    {

        return array_values(array_diff($table->allTimeSlots,$this->bookedSlots($table,$date)));
    }
    




    public function get_free_slots(Request $request)
    {
        $data = $request->validate([
            'table_id'=>'required',
            'date'=>'required|date|after:yesterday',
        ]);
        $table = Table::find($request->table_id);
        if($table){ 
            return response()->json([
                   'success' => true,
                   'message' => $table->name. ' available time slots!',
                   'data' => [ 
                    'booked_slots' => $this->bookedSlots($table,$data['date']), 
                    'availble_slots' => $this->availableTimeSlots($table,$data['date']),
                   ]
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message'=> 'Not found exception',
                'errors'=> [
                            'table_id'=>['Table not found!'],
                           ] 
            ],404);
        } 
    } 

    public function store(Request $request)
    {
        $data = $request->validate([
            'table_id'=>'required',
            'date'=>'required|date|after:yesterday',
            'time_slot'=>'required',
        ]);
        
        $data['customer_id'] = Auth::user()->userable_id;
        $table = Table::find($request->table_id);
        if($table){ 
            
            if(in_array($data['time_slot'], $this->bookedSlots($table,$data['date']))){

                return response()->json([
                    'success' => false,
                    'message' => 'Table Already Reaserved!'
                ],401);
            }    
            if(!in_array($data['time_slot'], $this->availableTimeSlots($table,$data['date']))){
    
                return response()->json([
                    'success' => false,
                    'errors' =>[
                        'time_slot'=>[
                            'Please select time from available slots!',
                        ]
                        ],
                ],401);
            }
        $booked_table = BookedTable::create($data);
        if($booked_table){
            return response()->json([
                'success' => true,
                'message'=> 'Table Booked Successfully!',
                'data' =>  new BookedTableResource($booked_table)
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message'=> 'Table Booking Failed!', 
            ]);
        }
    }else{
        return response()->json([
            'success' => false,
            'message'=> 'Not found exception',
            'errors'=> [
                        'table_id'=>['Table not found!'],
                       ] 
        ],404);
    } 
    }
    public function update(Request $request,$id)
    {
        $data = $request->validate([ 
            'date'=>'required|date|after:yesterday',
            'time_slot'=>'required',
        ]);

        $bookedTable = BookedTable::find($id);
        if(!$bookedTable){
              return response()->json([
                  'success' => false,
                  'message'=> 'Reservation not Found!'
              ]);
        }
        if($bookedTable->time_slot == $data['time_slot'] && $bookedTable->date == $data['date']){
            return response()->json([
                'success' => false,
                'message' => 'No Change Made!'
            ]);
        }
        
        
        $auth_user = Auth::user();
        $data['customer_id'] = $auth_user->userable_id; 
        $table = Table::find($bookedTable->table_id);
        if(!$table){ 
            return response()->json([
                'success' => false,
                'message' => 'Not found exception',
                'errors' => ['table_id'=>['Table not found!']] 
            ],404);
        }
        if(in_array($data['time_slot'], $this->bookedSlots($table,$data['date']))){ 
            return response()->json([
                'success' => false,
                'message' => 'Table Already Reaserved!'
            ],401);
        } 
        if(!in_array($data['time_slot'], $this->availableTimeSlots($table,$data['date']))){
    
            return response()->json([
                'success' => false,
                'errors' =>[
                    'time_slot'=>[
                        'Please select time from available slots!',
                    ]
                    ],
            ],401);
        }

        $booked_table = $bookedTable->update($data);
        if($booked_table){
            return response()->json([
                'success' => true,
                'message'=> 'Table Updated Successfully!',
                'data' => $booked_table
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message'=> 'Table Booking Failed!', 
            ]);
        }
    
    }

    public function destroy($id)
    {
        $booked_table = BookedTable::find($id);
        if(!$booked_table){   
             return response()->json([
                "success" => false,
                "message" => "Reservation Not Found."
            ]);
        }

            $booked_table->delete();
            return response()->json([
                "success" => true,
                "message" => "Reservation Canceled!"
            ]);
        

       
    }
}
