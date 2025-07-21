<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function history()
    {
        return view('pages.history');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function team()
    {
        return view('pages.team');
    }

    public function finances()
    {
        return view('pages.finances');
    }

    public function board()
    {
        return view('pages.board');
    }
}
