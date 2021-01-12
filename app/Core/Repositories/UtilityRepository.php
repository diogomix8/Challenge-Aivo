<?php

namespace App\Core\Repositories;

use Illuminate\Support\Facades\Http;

class UtilityRepository
{
    /**
     * Obtiene un Token de Acceso a la API Web de Spotify a partir de Client ID y del Client Secret
     */
    public function getTokenAcces()
    {
        $response = Http::withBasicAuth(env('CLIENT_ID'), env('CLIENT_SECRET'))
        ->asForm()
        ->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials'
        ]);

        $element = json_decode($response, true);
        $token = $element['access_token'];

        return $token;
    }
}
