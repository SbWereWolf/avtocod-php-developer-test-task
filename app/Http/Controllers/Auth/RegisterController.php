<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/reg_success';

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
        $notification = [
            'name.not_regex' =>
                'Логин должен состотоять только из букв и цифры и не должен содержать пробелов',
            'password.regex' =>
                'В пароле должна быть хотя бы одна прописная буква, хотя бы одна заглавная буква и хотя бы одна цифра',
        ];
        return Validator::make($data,
            ['name' => ['required','string','min:8','max:60',
                'not_regex:/\W\D|\s/'],
            'password' => ['required','string','min:6','confirmed',
                'regex:/(?=.*[A-Z]{1})(?=.*[a-z]{1})(?=.*\d{1})/'],],
            $notification);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
