<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function show()
    {
        return view('groups.mygroups')
            ->with('role', Auth::user()->account_type)
            ->with('t_teacherGroups', $this->t_getTeachers())
            ->with('t_studentGroups', $this->t_getStudents())
            ->with('s_studentGroups', $this->s_getStudents());
    }

    public function t_getTeachers()
    {
        return DB::table('groups as gr')
            ->select('*')
            ->addSelect(DB::raw('(SELECT COUNT(usm.user_id)
                        FROM users_memberships usm
                        WHERE usm.group_id = gr.id ) AS pocet'))
            ->where('type', '=', 'teachers')
            ->where('owner', '=', Auth::user()->id)
            ->get();
    }

    public function t_getStudents()
    {
        return DB::table('groups as gr')
            ->select('*')
            ->addSelect(DB::raw('(SELECT COUNT(usm.user_id)
                        FROM users_memberships usm
                        WHERE usm.group_id = gr.id ) AS pocet'))
            ->where('type', '=', 'students')
            ->where('owner', '=', Auth::user()->id)
            ->get();
    }

    public function s_getStudents()
    {
        return DB::table('groups as gr')
            ->select('*')
            ->addSelect(DB::raw('(SELECT COUNT(usm.user_id)
                        FROM users_memberships usm
                        WHERE usm.group_id = mb.group_id ) AS pocet'))
            ->rightJoin('users_memberships as mb', 'gr.id', '=', 'mb.group_id')
            ->where('type', '=', 'students')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
    }

    public function clickEdit(Request $request)
    {
        return redirect('edit-group')
            ->with('group_id', $request->group_id);
    }

    public function clickShow(Request $request)
    {
        return redirect('edit-group')
            ->with('group_id', $request->group_id);
    }
}