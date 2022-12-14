<?php

/**********************************************************/
/*                                                        */
/* File: RegisterController.php                           */
/* Author: David Chocholaty <xchoch09@stud.fit.vutbr.cz>  */
/* Project: Project for the course ITU                    */
/* Description: Controller for the register view.         */
/*                                                        */
/**********************************************************/

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Controller for the register view.
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'degree_front' => ['string', 'nullable', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'degree_after' => ['string', 'nullable', 'max:255'],
            'school' => ['string', 'nullable', 'max:255'],
            'account_type' => ['required', Rule::in(['student', 'teacher'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        /*
         * If the new account is student account type, ignore following text fields:
         * - degree_front
         * - degree_after
         * - school
         */
        if (strcmp($data['account_type'], 'student') == 0)
        {
            $data['degree_front'] = null;
            $data['degree_after'] = null;
            $data['school'] = null;
        }

        return User::create([
            'email' => $data['email'],
            'degree_front' => $data['degree_front'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'degree_after' => $data['degree_after'],
            'school' => $data['school'],
            'account_type' =>  $data['account_type'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
