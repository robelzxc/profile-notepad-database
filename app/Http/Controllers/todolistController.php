<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Validator;

class todolistController extends Controller
{
    function list(){
        return Todo::all();
    }
    function index($id){
        return Todo::find($id);
    }
    function add(Request $req)
    {
        $todo = new Todo;
        $todo->title=$req->title;
        $todo->description=$req->description;
        $result=$todo->save();
        if($result){
        return ['Result'=>'Data has been saved'];
        }
        else
        {
            return ['Operation' => "Failed"];
        }
    }
    function update(Request $req){
        $todo= Todo::find($req->id);
        $todo->title=$req->title;
        $todo->description=$req->description;
        $result= $todo->save();
        if($result){
            return ['result' => 'data is updated'];
        }
        else{
            return ['Operation' => 'Failed'];
        }
    }
    function delete($id){
        $todo= Todo::find($id);
        $result=$todo->delete();
        if($result){
            return ['result'=>'data is deleted'];
        }else{
            return ['Operation'=>'Failed'];
        }
    }
    function search($title){
        $result = Todo::where('title','like','%'.$title.'%')->get();
        
        if(sizeof($result)== 0){
            return "There is no match";
        }else {
            return $result;
        }
    }
    function testData(Request $req){
        $rules = array(
            'description' => 'required|min:5|max:100',
            'title'=>'required|min:1|max:10'
        );
        $validator = Validator::make($req->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->erorrs(),401);
        }
        else{
            $todo= new Todo;
            $todo->title=$req->title;
            $todo->description=$req->description;
            $result=$todo->save();
            if($result){
                return ['Result'=>'Data has been saved'];
            }
            else{
                return ['Result'=>"Operation failed"];
            }
        }
    }
}
