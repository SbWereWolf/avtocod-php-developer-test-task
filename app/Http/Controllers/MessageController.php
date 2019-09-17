<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Scribe;
use App\BusinessLogic\UserBlock;
use App\Http\Validation;
use App\Http\WebRouter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    /**
     * Показать все сообщения
     *
     * @return Response
     */
    public function index()
    {
        $twits['messages'] = Scribe::getAll();
        $userBlock = UserBlock::get();

        $pageData = array_merge($twits, $userBlock);

        return view('messages.index', $pageData);
    }

    /**
     * Написать на стене сообщение
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $userId = (int)auth()->id();
        Validation::ofAuthentication($userId)->validate();

        $content = (string)$request[Validation::CONTENT];
        Validation::beforeStore($content)->validate();

        /* @var $user \App\Models\User */
        $user = auth()->user();
        $handler = new Scribe($user);
        $handler->store($content);

        return redirect()->route(WebRouter::ALL_MESSAGES);
    }

    /**
     * Стереть со стены сообщение
     *
     * @param \App\Models\Message $message
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        $userId = (int)auth()->id();
        Validation::ofAuthentication($userId)->validate();

        $message = (int)$request[Validation::ID];
        Validation::beforeDestroy($message)->validate();

        /* @var $user \App\Models\User */
        $user = auth()->user();
        $handler = new Scribe($user);
        $handler->destroy($message);

        return redirect()->route(WebRouter::ALL_MESSAGES);
    }
}
