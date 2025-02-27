<?php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ConversationController;

Route::post('/chat', [ChatController::class, 'chat']);

Route::post('/conversations-create', [ConversationController::class, 'create']);
