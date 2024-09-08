<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\todo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function home() {
        $category=Category::all();
        $todo_list=todo::with('category')->get();
        return view('index',compact('category','todo_list'));
        
    }
    public function create_todo(Request $request){
        $todo = new todo;
        $todo->text=$request->text;
        $todo->is_compelete=false;
        $todo->category_id=$request->category;
        $todo->status="Active";




        $today=Carbon::today();
        $todayFormatted = $today->format('Y-m-d');  // Outputs in the format "2024-08-29"
        $todo->date=$todayFormatted;
        $todo->save();
        return redirect()->back();

    }
    public function Update_todo(Request $request,$id){
        $todo=todo::find($id);
        if ($todo) {
            // If the checkbox is checked, the value will be '1', otherwise '0'
            $todo->status = $request->status == 1 ? 'Complete' : 'Active';
            $todo->save();
        }
        return redirect()->back();
        
    }
    function update_todo_list($id){
        $todo=todo::with('category')->find($id);
        $category=Category::all();
        $todo_list=todo::with('category')->get();
        return view('update_todo_list',compact('todo','category','todo_list'));
    }
    function todo_list_updated_confirmed(Request $request , $id){
        $todo=todo::find($id);
        $todo->text=$request->text;
        $todo->category_id=$request->category;
        $todo->save();
        return redirect('/');
    }

    public function delete_todo_list($id){
        $todo=todo::find($id);
        $todo->delete();
        return redirect()->back();
    }
}
