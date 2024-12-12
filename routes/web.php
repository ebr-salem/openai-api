<?php

use App\AI\Chat;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    $chat = new Chat;

    $chat
        ->systemMessage('You are a helpful assistant.')
        ->send('How are you?');

    $response = $chat->reply('Can i tell you a something?');

    dd($response);
});
