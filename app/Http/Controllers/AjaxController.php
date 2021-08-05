<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Reply;

class AjaxController extends Controller
{
    public function create()
    {
      return view('topic');
    }

    public function store(Request $request)
    {
        if ($request->ajax())
        {
            $action = $request->input('action');
            $reply_id = $request->input('reply_id');
            $user_id = $request->input('user_id');
            
            if($action === "like")
            {
                $reply = Reply::find($reply_id);
                $reply->like($user_id);
            }
            else if($action === "unlike")
            {
                $reply = Reply::find($reply_id);
                $reply->unlike($user_id);
            }
    
            $likeCount = $reply->likeCount;
    
            return response()->json(['success'=>'Ajax request submitted successfully', 'likeCount'=>$likeCount, 'reply'=> $reply_id, 'action'=>$action]);
        }
    }
}
