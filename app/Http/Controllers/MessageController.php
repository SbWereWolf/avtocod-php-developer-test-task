<?php

namespace App\Http\Controllers;

use App\BusinessLogic\UserBlock;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    const CONTENT = 'content';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $twits['messages'] = Message::withAuthors()->all();

        $userBlock = UserBlock::get();

        $pageData = array_merge($twits, $userBlock);
        return view('messages.index', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id = auth()->user()->getAuthIdentifier();
        $data = $request->all();

        $this->validator($data)->validate();
        Message::create([
            Message::CONTENT => $data[self::CONTENT],
            Message::USER => $id,
        ]);

        return redirect('/');
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            self::CONTENT => 'required|string|max:255',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Message $message
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
