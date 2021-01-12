<?php

namespace App\Http\Controllers\Api;

use App\Core\Repositories\SpotifyRepository;
use App\Core\Repositories\UtilityRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    public function index(
        Request $request,
        UtilityRepository $utilityRepository,
        SpotifyRepository $spotifyRepository
    )
    {

        $acces_token = $utilityRepository->getTokenAcces();

        $id_artist = $spotifyRepository->searchArtist($request->q, $acces_token);

        $response = $spotifyRepository->getAlbumsByArtist($id_artist,$acces_token);

        return $response;
    }

}
