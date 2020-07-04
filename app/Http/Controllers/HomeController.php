<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThesisReservation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function createThesisReservation(Request $request){
        $thesis = new ThesisReservation();
        $thesis->title = $request->title;
        $thesis->status = $request->status;
        $thesis->user_id = $request->user_id;
        $thesis->teacher_id = $request->teacher_id;
        $thesis->save();
        return $thesis;
    }
}
