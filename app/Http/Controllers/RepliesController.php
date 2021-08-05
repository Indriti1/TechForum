<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;
use App\Models\Categories;
use Auth;

class RepliesController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string',
        ]);

        $reply = new Reply();
        $reply->user_id = Auth::user()->id;
        $reply->categories_id = $request->input('categories_id');
        $reply->topic_id = $request->input('topic_id');
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move(public_path('images'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName);}
        $reply->description = $request->input('description');
        $reply->save();

        return redirect()->back(); 
    }

    public function index(){
        $replies = Reply::where('isTopicPost', 0)->get()->paginate(10);
        $categories = Categories::all();
        $users = User::all();
        $topics = Topic::all();
        $user = Auth::user();
        if($user->isAdmin == 1)
        {
            return view('adminLte.replies.dashboardReplies', [
                'replies' => $replies,
                'topics' => $topics,
                'categories' => $categories,
                'users' => $users,
                'user' => $user,
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
            Reply::destroy($id);
            return redirect()->route('indexReplies');
        }
        else{
            return redirect()->route('categories.index');
        }
    }

    public function userDeleteReply($id){
        $reply = Reply::find($id);
        $topicid = $reply->topic_id;
        $reply->delete();
        return redirect()->route('topics.show', ['topic' => $topicid]);
    }

}
