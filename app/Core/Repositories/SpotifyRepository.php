<?php

namespace App\Core\Repositories;

use Illuminate\Support\Facades\Http;

class SpotifyRepository
{
    /**
     * Busca un Artista y devuelve el primero de la lista
     */
    public function searchArtist(String $search, String $token)
    {
        $response = Http::withToken($token)->get('https://api.spotify.com/v1/search', [
            'q' => $search,
            'type' => 'artist',
            'limit' => 1
        ]);
        
        $data = json_decode($response, true);
        
        foreach ( $data as $item)
        {
            foreach ( $item["items"] as $e) {
                $idArtist = $e["id"];
            }
            
        }
        return $idArtist;
    }
    
    /**
     * Obtiene todos los albunes del Artista y luego se formatea el array para pasarlo como JSON
     */
    public function getAlbumsByArtist(String $id_artist, String $token)
    {
        $searchArtist2 = Http::withToken($token)->get("https://api.spotify.com/v1/artists/$id_artist/albums");

        $albums = json_decode($searchArtist2, true);

        foreach ($albums["items"] as $album) {

            $dateFormat = date('d-m-Y', strtotime( $album["release_date"]));
            $cover_album = [];
            foreach ($album["images"] as $item) {
                if ( $item["height"] == 640)
                {
                    $cover_album = array(
                        "height" => $item["height"],
                        "width" => $item["width"], 
                        "url" => $item["url"]                         
                    );
                }
            }
            $arrayAlbum [] = array(
                "name" => $album["name"],
                "released" => $dateFormat,
                "track" => $album["total_tracks"],
                "cover" => $cover_album

            );
            
        }
        $response = json_encode($arrayAlbum, true);

        return $response;
    }
}