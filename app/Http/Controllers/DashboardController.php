<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\Comments;
use App\Models\User;

class DashboardController extends Controller
{
    public function index() : View {
        return view("dashboard.index",
            [
                'posts' => Post::where('status','published')->count(),
                'comments' => Comments::where('status','approved')->count(),
                'pendingcomments' => Comments::where('status','pending')->count(),
                'users' => User::count()
            ]);
    }
}
