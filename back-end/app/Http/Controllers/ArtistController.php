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


class ArtistController extends Controller
{
    use ApiHelpers;
    public function list(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($this->isAdmin($user) || $this->isUser($user)) {
            //$artist = Artist::all();
            //return $this->onSuccess($artist, 'Artist Retrieved');
            $artist = Artist::with('albums')->get();
            return response()->json($artist,200);
        }

        return $this->onError(401, 'Unauthorized Access');
    }
    public function view(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        if ($this->isAdmin($user) || $this->isUser($user)) {
            $post = DB::table('artist')->where('id', $id)->first();
            if (!empty($post)) {
                return $this->onSuccess($post, 'Artist Retrieved');
            }
            return $this->onError(404, 'Artist Not Found');
        }
        return $this->onError(401, 'Unauthorized Access');
    }

}
