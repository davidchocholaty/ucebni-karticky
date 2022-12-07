<?php

namespace App\Http\Controllers\Administration;



use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller for the user-administration view.
 */
class UserAdministrationController extends Controller
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
     * The index of the user-administration view.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
         return view('administration.user-administration');

    }

    /**
     * Function for dynamic searching of the users in the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        if ($request->keyword != '')
        {
            $result = User::where(DB::raw("CONCAT(`first_name`, ' ', `last_name`)"), 'LIKE', "%".$request->keyword."%")
                ->where( 'account_type', '<>', 'admin')
                ->get();
        }
        else
        {
            $result = User::where( 'account_type', '<>', 'admin')->get();
        }

        return response()->json(['result' => $result]);
    }

    /**
     * Function for removing the user from the database.
     *
     * @param Request $request
     */
    public function removeUser(Request $request)
    {
        DB::table('users')
            ->where('id', $request->user_id)
            ->delete();
    }
}
