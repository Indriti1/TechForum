<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Topic;
use App\Models\User;
use App\Models\Reply;
use Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        $usersCount = User::count();
        $categoriesCount = Categories::count();
        $repliesCount = Reply::count();
        $topicsCount = Topic::count();

        $latestUser = User::latest();
        $latestCategory = Categories::latest();
        $latestReply = Reply::latest();
        $latestTopic = Topic::latest();

        $categories = Categories::all();
        $allTopics = Topic::count();
        $allReplies = Reply::count();
        $allUsers = User::count();
        $latestTopics = Topic::latest()->take(4)->get();
        $latestUser = User::latest()->first();

        $user = Auth::user();

        if($user->isAdmin == 1)
        {
            return view('adminLte.dashboard.dashboard' , [
                'user' => $user,
                'usersCount' => $usersCount,
                'categoriesCount' => $categoriesCount,
                'repliesCount' => $repliesCount - $topicsCount,
                'topicsCount' => $topicsCount,
            ]);
        }
        else {
            return redirect()->route('categories.index');
        }
    }
}
