<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Library\ApiHelpers;
use App\Services\AlbumService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use phpDocumentor\Reflection\Types\This;

class AlbumController extends Controller
{
    use ApiHelpers;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    public function list(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($this->isAdmin($user) || $this->isUser($user)) {

            $album = $this->albumService->all();

            return response()->json($album, 200);
        }

        return $this->onError(401, 'Unauthorized Access');
    }

    public function view(Request $request, $id): JsonResponse
    {
        $user = $request->user();

        if ($this->isAdmin($user) || $this->isUser($user)) {

            $album = $this->albumService->find($id);

            if (!empty($album)) {
                return $this->onSuccess($album, 'Album Retrieved');
            }

            return $this->onError(404, 'Album Not Found');
        }

        return $this->onError(401, 'Unauthorized Access');
    }

    public function add(Request $request): JsonResponse
    {

        $user = $request->user();

        if ($this->isAdmin($user) || $this->isUser($user)) {

            $validator = Validator::make($request->all(), $this->albumService->getValidationRules());

            if ($validator->validated()) {

                $album = $this->albumService->create($request->all());

                return $this->onSuccess($album, 'Album Created');
            }

            return $this->onError(400, $validator->errors());
        }

        return $this->onError(401, 'Unauthorized Access');
    }

    public function edit(Request $request, $id): JsonResponse
    {
        $user = $request->user();

        if ($this->isAdmin($user) || $this->isUser($user)) {

            $validator = Validator::make($request->all(), $this->albumService->getValidationRules($id));

            if ($validator->validated()) {

                $album = $this->albumService->update($id, $request->all());

                return $this->onSuccess($album, 'Album Updated');
            }

            return $this->onError(400, $validator->errors());
        }

        return $this->onError(401, 'Unauthorized Access');
    }

    public function delete(Request $request, $id): JsonResponse
    {
        $user = $request->user();

        if ($this->isAdmin($user)) {

            $album = $this->albumService->delete($id);

            if (!empty($album)) {
                return $this->onSuccess($album, 'Album Deleted');
            }

            return $this->onError(404, 'Album Not Found');
        }
        return $this->onError(401, 'Unauthorized Access');
    }
}
