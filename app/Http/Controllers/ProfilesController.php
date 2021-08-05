<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Topic;
use App\Models\Reply;
use App\Models\Categories;
use Auth;

class ProfilesController extends Controller
{
    public function show($user)
    {
        $categories = Categories::all();
        $users = User::all();
        $allTopics = Topic::all();
        $user = User::findOrFail($user);
        $topics = DB::table('topics')
                    ->join('replies', 'replies.topic_id', '=', 'topics.id')
                    ->join('users', 'users.id', '=', 'topics.user_id')
                    ->where('users.id', '=', $user->id)
                    ->where('replies.isTopicPost', '=', 1)
                    ->select('topics.id', 'topics.title','topics.created_at')
                    ->latest('topics.created_at')->take(5)->get();

        $replies = DB::table('replies')
                    ->join('topics', 'topics.id', '=', 'replies.topic_id')
                    ->where('replies.user_id', '=', $user->id)
                    ->where('replies.isTopicPost', '=', 0)
                    ->select('topics.id', 'topics.title','replies.created_at')
                    ->latest('replies.created_at')->take(5)->get();

        return view('user.profile', [
            'user' => $user,
            'topics' => $topics,
            'replies' => $replies,
            'users' => $users,
            'categories' => $categories,
            'allTopics' => $allTopics,
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.editProfile', [
            'user' => $user,
        ]);

    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'max:25',
            'occupation' => 'max:25',
            'specialization' => 'max:25',
            'about' => 'max:250', 
        ]);

        $user = Auth::id();
        $profile = Profile::find($user); 

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); 
            $fileName = time().'.'.$extension;
            $path = public_path().'/images';
            $image = $file->move($path,$fileName);
            $profile->image = $fileName;
        }

        $profile->location = $request->input('location');
        $profile->occupation = $request->input('occupation');
        $profile->specialization = $request->input('specialization');
        $profile->about = $request->input('about');
        $profile->save(); 

        return redirect('/profiles'.'/'.$user)->with('status', 'Profile Updated');
    }
}
