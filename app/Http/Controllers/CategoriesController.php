<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Topic;
use App\Models\User;
use App\Models\Reply;
use Auth;
use DB;

class CategoriesController extends Controller
{
    public function show($category)
    {
        $category = Categories::findOrFail($category);
        $categories = Categories::with('topics')->get()->all();
        $latestTopics = Topic::latest()->take(4)->get();
        $user = Auth::user();
        $latestUser = User::latest()->get();
        $topics = $category->topics()->withCount('replies');
        $topicsCount = $topics->count();
        $repliesCount = Reply::where('categories_id', $category->id)->count() - $topicsCount;
        

        $query1 = DB::table('topics')
                ->join('users', 'topics.user_id', '=', 'users.id')
                ->join('categories', 'categories.id', '=', 'topics.categories_id')                
                ->select('users.id')
                ->where('categories.id', '=', $category->id);
        
        $query2 = DB::table('replies')
                ->join('users', 'replies.user_id', '=', 'users.id')
                ->join('categories', 'categories.id', '=', 'replies.categories_id') 
                ->distinct('users.id')               
                ->select('users.id')
                ->where('categories.id', '=', $category->id)
                ->union($query1)
                ->get();

        $usersCount = count($query2);


        if(isset($_GET['sortTopics']) && !empty($_GET['sortTopics']))
        {
            if($_GET['sortTopics']=="oldestTopics")
            {
                $topics->orderBy('created_at', 'Asc');
            }
            if($_GET['sortTopics']=="recentTopics")
            {
                $topics->orderBy('created_at', 'Desc');
            }
            if($_GET['sortTopics']=="titleA-Z")
            {
                $topics->orderBy('title', 'Asc');
            }
            if($_GET['sortTopics']=="titleZ-A")
            {
                $topics->orderBy('title', 'Desc');
            }
        }
        else
        {
            $topics->orderBy('created_at', 'Desc');
        }
        
        $topics = $topics->paginate(10);

        return view('user.showTopics', [
            'topics' => $topics,
            'categories' => $categories,
            'latestTopics' => $latestTopics,
            'category' => $category,
            'user' => $user,
            'latest' => $latestUser,
            'topicsCount' => $topicsCount,
            'repliesCount' => $repliesCount,
            'usersCount' => $usersCount,
        ]);
    }

    public function index()
    {
        $categories = Categories::all();
        $allTopics = Topic::count();
        $allReplies = Reply::count() - $allTopics;
        $allUsers = User::count();
        $latestTopics = Topic::latest()->take(4)->get();
        $latestUser = User::latest()->first();
        return view('user.categories' , [
            'categories' => $categories,
            'latestTopics' => $latestTopics,
            'allTopics' => $allTopics,
            'allUsers' => $allUsers,
            'allReplies' => $allReplies,
            'latestUser' => $latestUser,
        ]);
    }

    public function showCategories(){
        $categories = Categories::all()->paginate(10);
        $user = Auth::user();
        if($user->isAdmin == 1)
        {   
            return view('adminLte.categories.dashboardCategories' , [
                'categories' => $categories,
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
            Categories::destroy($id);
            return redirect()->route('indexCategories');
        }
        else {
            return redirect()->route('categories.index');
        }
    }

    public function edit($id){
        $category = Categories::find($id);
        $user = Auth::user();
        if($user->isAdmin == 1)
        { 
            return view('adminLte.categories.editCategory' ,[
                'category' => $category,
                'user' => $user,
            ]);
        }
        else {
            return redirect()->route('categories.index');
        }
    }

    public function update(Request $request, $id){
        $user = Auth::user();
        if($user->isAdmin == 1)
        { 
            $category = Categories::find($id);
            $validatedData = $request->validate([
                'categoryTitle' => 'required',
                'description' => 'required',
            ]);

            $category->title = $request->input('categoryTitle');
            $category->description = $request->input('description');
            $category->save();

            $categories = Categories::all()->paginate(10);
            $user = Auth::user();

            return redirect()->route('indexCategories', [
                'categories' => $categories,
                'user' => $user,
            ]);
        }
        else{
            return redirect()->route('categories.index');
        }
    }

    public function create(Request $request){
        $user = Auth::user();
        if($user->isAdmin == 1)
        { 
            return view('adminLte.categories.addCategory', [
                'user' => $user,
            ]);
        }
        else{
            return redirect()->route('categories.index');
        }
    }

    public function store(Request $request){
        $user = Auth::user();
        if($user->isAdmin == 1)
        { 
            $validatedData = $request->validate([
                'categoryTitle' => 'required',
                'description' => 'required',
            ]);
            $category = new Categories();
            $category->title = $request->input('categoryTitle');
            $category->description = $request->input('description');
            $category->save();

            $categories = Categories::all()->paginate(10);
            $user = Auth::user();
            return redirect()->route('indexCategories', [
                'categories' => $categories,
                'user' => $user,
            ]);
        }
        else{
            return redirect()->route('categories.index');
        }
    }

}
