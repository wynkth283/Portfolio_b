<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function comments() 
    {
        return Comment::active()
                  ->with('user:id,name')
                  ->latest()
                  ->paginate(10);
    }

    public function create(Request $request) 
    {
        $request->validate([
            'cmt' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        if(!$user) { 
            return response()->json(['message' => 'Unauthorized'], 401); 
        }

        $comment = Comment::create([
            'content' => $request->input('cmt'),
            'user_id' => $user->id,
            'status' => true,
        ]);

        $comment->load('user:id,name');

        return response()->json([
            'message' => 'success',
            'comment' => $comment
        ], 201);
    }

    public function delete($id) 
    {
        $user = Auth::user();

        if(!$user) { 
            return response()->json(['message' => 'Unauthorized'], 401); 
        }

        $comment = Comment::find($id);

        if(!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        // Chỉ cho phép xóa nếu là chính chủ hoặc admin
        if($comment->user_id != $user->id && $user->role != 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
