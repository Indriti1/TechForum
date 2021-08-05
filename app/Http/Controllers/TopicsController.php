<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Topic;
use App\Models\User;
use App\Models\Reply;
use Auth;

class TopicsController extends Controller
{
    public function create()
    {
        $categories = Categories::all();
        return view('user.createTopic' , [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:topics,title|max:75',
            'description' => 'required|string',
        ]);

        $topic = new Topic();
        $topic->user_id = Auth::user()->id;
        $topic->categories_id = $request->input('category');
        $topic->title = $request->input('title');
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move(public_path('images'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName);
        }
        
        $topic->save();
        $reply = new Reply();
        $reply->user_id = Auth::user()->id;
        $reply->topic_id = $topic->id;
        $reply->categories_id = $request->input('category');
        $reply->description = $request->input('description');
        $reply->isTopicPost = 1;
        $reply->save();

        return redirect('/categories')->with('status', 'Topic Created');
    }

    public function show($topic)
    {
        $topic = Topic::findOrFail($topic);
        $categories = Categories::with('topics')->get()->all();
        $latestTopics = Topic::latest()->take(6)->get();
        $replies = Reply::where('topic_id', $topic->id)->paginate(5);
        $users = User::all();
        $user = Auth::user();

        return view('user.topic', [
            'topic' => $topic,
            'categories' => $categories,
            'latestTopics' => $latestTopics,
            'replies' => $replies,
            'users' => $users,
            'user' => $user,
        ]);
    }

    public function index(){
        $topics = Topic::all()->paginate(10);
        $categories = Categories::all();
        $users = User::all();
        $user = Auth::user();
        if($user->isAdmin == 1)
        {
            return view('adminLte.topics.dashboardTopics', [
                'topics' => $topics,
                'user' => $user,
                'users' => $users,
                'categories' => $categories,
            ]);
        }
        else{
            return redirect()->route('categories.index');
        }
    }

    public function delete($id){
        $user = Auth::user();
        if($user->isAdmin == 1)
        {
            $topic = Topic::find($id);
            $topic->replies()->delete();
            $topic->delete();
            return redirect()->route('indexTopics');
        }
        else{
            return redirect()->route('categories.index');
        }
    }

    public function userDeleteTopic($id){
        $topic = Topic::find($id);
        $topic->replies()->delete();
        $topic->delete();
        return redirect()->route('categories.index');
    }


}
