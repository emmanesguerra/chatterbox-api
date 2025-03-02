<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConversationRequest;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Services\ConversationService;
use Illuminate\Http\JsonResponse;

class ConversationController extends Controller
{
    protected $conversationService;

    public function __construct(ConversationService $conversationService)
    {
        $this->conversationService = $conversationService;
    }

    public function lists(): JsonResponse
    {
        $response = $this->conversationService->getConversations();

        return response()->json(ConversationResource::collection($response));
    }

    public function fetchMessages(int $conversation): JsonResponse
    {
        $response = $this->conversationService->getMessages($conversation);

        return response()->json(MessageResource::collection($response));
    }

    public function create(ConversationRequest $request): JsonResponse
    {
        $response = $this->conversationService->createConversation($request->input('message'));

        return response()->json($response);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->conversationService->deleteConversation($id);
    
        if (!$deleted) {
            return response()->json(['message' => 'Conversation not found.'], 404);
        }
    
        return response()->json(['message' => 'Conversation deleted successfully.'], 200);
    }
}
