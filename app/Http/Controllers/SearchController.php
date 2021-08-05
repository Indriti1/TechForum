<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\User;
use App\Models\Profile;
use App\Models\Categories;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $validatedData = $request->validate([
            'search' => 'required|max:25',
        ]);

        $search = $request->input('search');
        $searchBy = $request->input('searchBy');
        $userCheck;
        $topicCheck;
        $userCount; 
        $topicCount;
        
        if($searchBy=='user')
        {
            $userCheck = User::where('name', 'LIKE', '%'. $search . '%')->orderBy('created_at', 'desc');
            $userCount = $userCheck->count();
            return $this->showUsers($userCheck, $userCount, $search, $searchBy);
        }
        else if($searchBy=='title')
        {
            $topicCheck = Topic::where('title', 'LIKE', '%'. $search . '%')->orderBy('created_at', 'desc');;
            $topicCount = $topicCheck->count();
            return $this->showTopics($topicCheck, $topicCount, $search, $searchBy);
        }
    }

    public function showUsers($userCheck, $userCount, $search, $searchBy)
    {
        $latestTopics = Topic::latest()->take(6)->get();
        $users = $userCheck->paginate(10);
        $categories = Categories::all();
        $profiles = Profile::all();

        return view('user.searchUsers', [
            'users' => $users,
            'userCount' => $userCount,
            'profiles' => $profiles,
            'search' => $search,
            'searchBy' => $searchBy,
            'latestTopics' => $latestTopics,
            'categories' => $categories,
        ]);
    }

    public function showTopics($topicCheck, $topicCount, $search, $searchBy)
    {
        $latestTopics = Topic::latest()->take(6)->get();
        $topics = $topicCheck->withCount('replies')->paginate(10);
        $categories = Categories::all();
        $profiles = Profile::all();

        return view('user.searchTopics', [
            'topics' => $topics,
            'topicCount' => $topicCount,
            'profiles' => $profiles,
            'search' => $search,
            'searchBy' => $searchBy,
            'latestTopics' => $latestTopics,
            'categories' => $categories,
        ]);
    }
}

        
        

        

