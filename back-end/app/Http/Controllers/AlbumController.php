<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Library\ApiHelpers;
use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    use ApiHelpers;
    public function list(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($this->isAdmin($user) || $this->isUser($user)) {
            //$album = Album::all();
            $album = Album::with('artist')->get();
            return response()->json($album,200);
            //return $this->onSuccess($album, 'Album Retrieved');
        }

        return $this->onError(401, 'Unauthorized Access');
    }

    public function view(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isUser($user)) {
            $post = DB::table('albums')->where('id', $id)->first();
            if (!empty($post)) {
                return $this->onSuccess($post, 'Album Retrieved');
            }
            return $this->onError(404, 'Album Not Found');
        }
        return $this->onError(401, 'Unauthorized Access');
    }

    public function add(Request $request): JsonResponse
    {

        $user = $request->user();
        if ($this->isAdmin($user) || $this->isUser($user)) {
            $validator = Validator::make($request->all(), $this->albumValidationRules());
            if ($validator->validated()) {
                // Create New Album
                $album = new Album();
                $album->album_name = $request->input('album_name');
                $album->artist_id = $request->input('artist_id');
                $album->year = $request->input('year');
                $album->save();

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
            $validator = Validator::make($request->all(), $this->albumValidationRules());
            if ($validator->validated()) {
                // Create New Album
                $album = Album::find($id);
                $album->album_name = $request->input('album_name');
                $album->artist_id = $request->input('artist_id');
                $album->year = $request->input('year');
                $album->save();

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
            $album = Album::find($id); // Find the id of the album passed
            $album->delete(); // Delete the specific album data
            if (!empty($album)) {
                return $this->onSuccess($album, 'Album Deleted');
            }
            return $this->onError(404, 'Album Not Found');
        }
        return $this->onError(401, 'Unauthorized Access');
    }
}
