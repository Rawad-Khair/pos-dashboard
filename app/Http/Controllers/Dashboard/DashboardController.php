<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class DashboardController extends Controller
{
    public function index (Request $req) {
        $categories = Category::all();
        return view('dashboard.index')->with('categories',$categories);
    }
}
