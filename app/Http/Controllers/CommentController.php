<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function __construct(Request $request)
    {
        $this->user = auth()->setRequest($request)->user();

    }
    public function storePostComment(Request $request, $post_id){

        $validData = $request->validate([
            'content' => 'required|string'
        ]);
        $create_comment = Comment::create([
            'content' => $validData['content'],
            'post_id' => $post_id,
            'user_id' =>$this->user->id,
            'point' =>$request->point,
            'reply_to' =>$request->reply_to,

        ]);
        return redirect()->back();
    }
    public function store(Request $request,$user_id)
    {

        $validData = $request->validate([
            'content' => 'required|string'
        ]);
        $partner_id=null;
        $post_id=null;

        if ($request->isFromPartnerPage === '1') {
            $partner_id = $user_id;
            $post_id = null;
        }elseif ($request->isFromPartnerPage === '0'){
            $post_id = $user_id;
            $partner_id = null;
        }
        $create_comment = Comment::create([
            'content' => $validData['content'],
            'post_id' => $post_id,
            'partner_id' => $partner_id,
            'user_id' =>$this->user->id,
            'reply_to' =>$request->reply_to,
            'point' =>$request->point,
        ]);
        return back()->withSuccess(trans('lang.your_messsage_has_been_sent'));
    }

    public function edit(Comment $comment)
    {
        return view('comment-edit', [
            'comment' => $comment
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        $validData = $request->validate([
            'content' => 'required|string'
        ]);

        $comment->update([
            'content' => $validData['content'],
            'approved' => 0
        ]);

        session()->flash('commentResult', [
            'message' => 'Comment updated successfully, it will appear after approval',
            'success' => true
        ]);

        return redirect($comment->post->specificResourcePath());
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        session()->flash('commentResult', [
            'message' => 'Comment deleted successfully',
            'success' => true
        ]);

        return redirect($comment->post->specificResourcePath());
    }

    public function approve(Comment $comment)
    {
        return $comment->update(['approved' => true]);
    }

    public function undoApproval(Comment $comment)
    {
        return $comment->update(['approved' => false]);
    }
}
