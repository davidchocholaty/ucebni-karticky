<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\Attempt;
use App\Models\Exercise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserStatisticsController extends Controller
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

    public function index()
    {
        $user_id = Session::get('user_id');
        $exercise_id = Session::get('exercise_id');

        // TODO user name
        $exercise_name = Exercise::find($exercise_id, ['name']);

        return view('statistics.user-statistics')
            ->with('user_id', $user_id)
            ->with('exercise_id', $exercise_id)
            ->with('exercise_name', $exercise_name->name);
    }

    public function fastestAttempt($user_id, $exercise_id)
    {
        // SELECT * FROM ucebni_karticky.attempts WHERE user_id = '2' AND exercise_id = '14' order by spend_time limit 1;
        $fastest_attempt = DB::table('attempts')
            ->where('user_id', '=', $user_id)
            ->where('exercise_id', '=', $exercise_id)
            ->orderBy('spend_time')
            ->limit(1)
            ->get();

        return $fastest_attempt;
    }

    public function mostSuccessfulAttempt($user_id, $exercise_id)
    {
        //$mostSuccessfulAttempt = DB::table('attempts')
    }
}