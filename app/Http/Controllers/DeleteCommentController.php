<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class DeleteCommentController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws AuthorizationException
     */
    public function __invoke($id, Comment $comment): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        
        return back();
    }
}
