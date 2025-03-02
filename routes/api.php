<?php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ConversationController;

Route::post('/send-message', [ChatController::class, 'processMessage']);

Route::post('/conversations-create', [ConversationController::class, 'create']);
Route::get('/conversations', [ConversationController::class, 'lists']);
Route::get('/conversations/{conversation}/messages', [ConversationController::class, 'fetchMessages']);
