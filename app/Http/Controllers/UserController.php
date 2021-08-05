<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Topic;
use Auth;
use DB;

class UserController extends Controller
{
    public function index(){
        $users = User::all()->paginate(10);
        $user = Auth::user();
        if($user->isAdmin == 1)
        {
            return view('adminLte.users.dashboardUsers' , [
                'users' => $users,
                'user' => $user,
            ]);
        }
        else {
            return redirect()->route('categories.index');
        }
    }

    public function delete($id){
        $user = Auth::user();
        if($user->isAdmin == 1)
        {
            $deleteUser = User::find($id);
            $topics = Topic::where('user_id', $deleteUser->id)->get()->all();
            foreach ($topics as $topic){
                $topic->replies()->delete();
            }
            $topic->delete();
            $deleteUser->delete();
            return redirect()->route('indexUsers');
        }
        else{
            return redirect()->route('categories.index');
        }
    }

    public function edit($id){
        $loggedUser = Auth::user();
        if($loggedUser->isAdmin == 1)
        {
            $user = User::find($id);
            return view('adminLte.users.editUser' ,[
                'user' => $user,
                'loggedUser' => $loggedUser,
            ]);
        }
        else{
            return redirect()->route('categories.index');
        }
    }

    public function update(Request $request, $id){
        $loggedUser = Auth::user();
        if($loggedUser->isAdmin == 1)
        {
            $user = User::find($id);
            $isAdmin;
            $validatedData = $request->validate([
                'userName' => 'required',
                'userEmail' => 'required',
                'radio' => 'required|in:user,admin'
            ]);

            $user->name = $request->input('userName');
            $user->email = $request->input('userEmail');
            $radio = $request->input('radio');

            if($radio=="user"){
                $isAdmin = 0;
            }
            else if ($radio=="admin"){
                $isAdmin = 1;
            }

            $user->isAdmin =$isAdmin;
            $user->save();

            $users = User::all()->paginate(10);
            $user = Auth::user();
            return redirect()->route('indexUsers', [
                'users' => $users,
                'user' => $user
            ]);
        }
        else{
            return redirect()->route('categories.index');
        }
    }

}
