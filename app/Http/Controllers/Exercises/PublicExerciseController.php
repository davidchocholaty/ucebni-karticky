<?php

namespace App\Http\Controllers\Exercises;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PublicExerciseController extends Controller
{
    /**
     * Return view of public exercises
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('exercises.public-exercises')
            ->with('exercises', $this->publicExercises());
    }

    /**
     * Function which return all public exercises
     *
     * @return \Illuminate\Support\Collection
     */
    public function publicExercises()
    {
        return DB::table('exercises AS ex')
            ->select(DB::raw('ex.id, ex.name AS e_name, ex.topic, ex.description'))
            ->addSelect(DB::raw('(SELECT COUNT(*)
                        FROM flashcards fs
                        WHERE fs.exercise_id = ex.id) AS pocet'))
            ->where('ex.visibility', '=', 'public')
            ->get();
    }
}
