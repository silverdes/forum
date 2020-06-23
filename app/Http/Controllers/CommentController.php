<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Topic $topic){
        request()->validate([
            'content' => 'required|min:5'
        ]);

        $comment = new Comment();
        $comment->content = request('content');
        $comment->user_id = auth()->user()->id;

        $topic->comments()->save($comment);

        return redirect()->route('topics.show', $topic);
        
    }

    
    public function storeCommentReply(Comment $comment){
        request()->validate([
            'replyComment' => 'required|min:5'
        ]);

        $commentReply = new Comment();
        $commentReply->content = request('replyComment');
        $commentReply->user_id = auth()->user()->id;

        $comment->comments()->save($commentReply);

        return redirect()->back();
    }

    public function markedAsSolution(Topic $topic, Comment $comment){
        if(auth()->user()->id === $topic->user_id){
            $topic->solution = $comment->id;
            $topic->save();

            return response()->json(['success' => ['success'=>'marked as solution']], 200);
        }else{
            return response()->json(['errors' => ['error'=> 'Unvalid user']], 401);
        }
    }
}
