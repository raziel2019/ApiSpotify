<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\HasApiTokens;
use Dedoc\Scramble\Attributes\Route;
use Dedoc\Scramble\Attributes\Response;
use Dedoc\Scramble\Attributes\SchemaName;
use Dedoc\Scramble\Attributes\Schema;

#[SchemaName(title: 'Spotify API', version: '1.0')]
class SpotifyController extends Controller
{
    use HasApiTokens;
    private $client_id;
    private $client_secret;
    
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
         $this->client_id = env('SPOTIFY_CLIENT_ID');
         $this->client_secret = env('SPOTIFY_CLIENT_SECRET');
    }

    private function getAccessToken()
    {
        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
        ]);

        return $response->json()['access_token'] ?? null;
    }

    #[Route('GET', '/api/spotify/artist')]
    #[Schema(description: 'Obtener información de un artista por su nombre')]
    #[Response(200, description: 'Datos del artista desde Spotify')]
    #[Response(400, description: 'Parámetro faltante')]

    public function searchArtist(Request $request)
    {
        $artistName = $request->query('artist');
        if (!$artistName) {
            return response()->json(['error' => 'El parámetro artist es requerido'], 400);
        }

        $token = $this->getAccessToken();
        if (!$token) {
            return response()->json(['error' => 'No se pudo obtener el token de acceso'], 500);
        }

        $response = Http::withHeaders([ 'Authorization' => 'Bearer ' . $token ])
            ->get("https://api.spotify.com/v1/search", [
                'q' => $artistName,
                'type' => 'artist',
                'limit' => 1,
            ]);

        return response()->json($response->json());
    }

}