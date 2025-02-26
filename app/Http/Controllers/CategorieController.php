<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
// use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    public function create(Request $request){

        if ($request->user('sanctum')) {
            $request->validate([
                'name' => 'required|string|min:5',
            ]);

            $user = $request->user();

            // preciso conferir se ja existe uma dessa com esse nome para esse usuario atraves do slug

            Categorie::create([
                "user_id" => $user->id,
                "name" => $request->name,
                "slug" => $request->name,
                "is_active" => 1
            ]);


            return response()->json([
                "status" => 1,
                "message" => "categorie created"
            ]);
        } else {
                return response()->json([
                    'status' =>  0,
                    'message' => "user is not authenticated"
                ]);
        }
    }

    public function list(Request $request){

        if ($request->user('sanctum')) {

            $user = $request->user();
            $data = Categorie::select(['id','name','slug'])->where('user_id', $user->id)->where('is_active',1)->orderByDesc('created_at')->get();
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

    // protected function generateSlug($name)
    // {
    //     $slug = Str::slug(Str::lower($name), '-');
    //     $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

    //     $originalSlug = $slug;
    //     $count = 1;
    //     while (Category::where('slug', $slug)->exists()) {
    //         $slug = $originalSlug . '-' . $count;
    //         $count++;
    //     }

    //     return $slug;
    // }


}