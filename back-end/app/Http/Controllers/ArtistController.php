<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Library\ApiHelpers;
use Illuminate\Http\JsonResponse;
use App\Services\ArtistService;
use phpDocumentor\Reflection\Types\This;

class ArtistController extends Controller
{
    use ApiHelpers;

    public function __construct(ArtistService $artistService)
    {
        $this->artistService = $artistService;
    }

    public function list(Request $request): JsonResponse
    {

        $user = $request->user();

        if ($this->isAdmin($user) || $this->isUser($user)) {

            $artist = $this->artistService->all();

            return response()->json($artist, 200);
        }

        return $this->onError(401, 'Unauthorized Access');
    }

    public function view(Request $request, $id): JsonResponse
    {
        $user = $request->user();

        if ($this->isAdmin($user) || $this->isUser($user)) {

            $artist = $this->artistService->find($id);

            return response()->json($artist, 200);
        }
        return $this->onError(401, 'Unauthorized Access');
    }
}
