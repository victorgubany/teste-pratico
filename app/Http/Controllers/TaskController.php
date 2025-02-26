<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function list(Request $request){
        if ($request->user('sanctum')) {
            $user = $request->user();
            if($request->query('categorie')){
                $data = Task::select(['id','name','status','categorie_id'])->with(['categorie'=>function($q){
                    $q->select(['id','name','slug']);
                }])->where('categorie_id',$request->query('categorie'))->where('user_id', $user->id)->orderByDesc('created_at')->get();
            }
            else{
                $data = Task::select(['id','name','status','categorie_id'])->with(['categorie'=>function($q){
                    $q->select(['id','name','slug']);
                }])->where('user_id', $user->id)->orderByDesc('created_at')->get();
            }

            return response()->json([
                "status" => 1,
                "data" => $data
            ]);
        }
        else{
            return response()->json([
                'status' =>  0,
                'message' => "user is not authenticated"
            ]);
        }

    }

    public function create(Request $request){
        if ($request->user('sanctum')) {
            $request->validate([
                'name' => 'required|string|min:5',
                'categorie' => 'required|numeric'
            ]);
            $user = $request->user();

            $categorie = Categorie::where('user_id',$user->id)->where('id',$request->categorie)->exists();

            if(!$categorie){
                return response()->json([
                    'status' => 0,
                    "message" => "The categorie does not exist"

                ],404);
            }

            Task::create([
                "user_id" => $user->id,
                "categorie_id" => $request->categorie,
                "name" => $request->name,
                "status" => 0
            ]);


            return response()->json([
                "status" => 1,
                "message" => "task created"
            ]);
        } else {
                return response()->json([
                    'status' =>  0,
                    'message' => "user is not authenticated"
                ]);
        }

    }

    public function update(Request $request){
        if ($request->user('sanctum')) {
            $request->validate([
                'id' => "required|numeric",
                'status' => 'required|numeric|in:0,1,2'
            ]);

            $user = $request->user();

            $task = Task::where('id', $request->id)->where('user_id',$user->id)->exists();

            if(!$task){
                return response()->json([
                    "status" => 1,
                    "data" => "This user dont have this task"
                ]);

            }

            Task::where('id', $request->id)->where('user_id',$user->id)->update(['status'=>$request->status]);


            return response()->json([
                "status" => 1,
                "data" => "Task was updated"
            ]);
        }
        else{
            return response()->json([
                'status' =>  0,
                'message' => "user is not authenticated"
            ]);
        }

    }

    public function delete(Request $request){

        if ($request->user('sanctum')) {
            $request->validate([
                'id' => "required|numeric"
            ]);

            $user = $request->user();

            $task = Task::where('id', $request->id)->where('user_id',$user->id)->exists();

            if(!$task){
                return response()->json([
                    "status" => 1,
                    "data" => "This user dont have this task"
                ]);

            }
            Task::where('id', $request->id)->where('user_id',$user->id)->delete();


            return response()->json([
                "status" => 1,
                "data" => "Task was deleted"
            ]);
        }
        else{
            return response()->json([
                'status' =>  0,
                'message' => "user is not authenticated"
            ]);
        }




    }
}