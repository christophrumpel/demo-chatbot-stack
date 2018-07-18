<?php

use App\Http\Conversations\MeetingsConversation;
use BotMan\BotMan\BotMan;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});

$botman->hears('Hey', function ($bot) {
    $bot->reply('Hey you too!');
});

$botman->hears('next meeting', function (BotMan $bot) {
    $bot->startConversation(new MeetingsConversation());
});
