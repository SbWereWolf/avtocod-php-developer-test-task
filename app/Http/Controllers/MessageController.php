<?php

namespace App\Http\Controllers;

use App\BusinessLogic\MessageHandler;
use App\BusinessLogic\UserBlock;
use App\Http\Validation;
use App\Http\WebRouter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $twits['messages'] = MessageHandler::getAll();
        $userBlock = UserBlock::get();

        $pageData = array_merge($twits, $userBlock);

        return view('messages.index', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $user = (int)auth()->id();
        Validation::ofAuthentication($user)->validate();

        $content = (string)$request[Validation::CONTENT];
        Validation::beforeStore($content)->validate();

        $handler = new MessageHandler($user);
        $handler->store($content);

        return redirect()->route(WebRouter::ALL_MESSAGES);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Message $message
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        $user = (int)auth()->id();
        Validation::ofAuthentication($user)->validate();

        $message = (int)$request[Validation::ID];
        Validation::beforeDestroy($message)->validate();

        $handler = new MessageHandler($user);
        $handler->destroy($message);

        return redirect()->route(WebRouter::ALL_MESSAGES);
    }
}
