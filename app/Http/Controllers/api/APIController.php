<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Locations\City;
use App\Models\Locations\Country;
use App\Models\Locations\State;
use App\Models\Master\Goal;
use App\Models\Master\IndustryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class APIController extends Controller
{
    public function createNewGoal(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        // Create the new goal in the database
        $goal = Goal::create([
            'name' => $validatedData['name'],
        ]);
        return response()->json([
            'name' => $goal->name,
            'id' => $goal->id,
        ]);
    }

    public function countryList()
    {
        return Country::orderBy('name')->get(['id', 'name']);
    }

    public function states($country_id)
    {
        return State::where('country_id', $country_id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function cities($state_id)
    {
        return City::where('state_id', $state_id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function industryType()
    {
        return IndustryType::orderBy('name')->get(['id', 'name']);
    }

    /*public function get_europa_skills()
    {
        $url = 'https://ec.europa.eu/esco/api/resource/skill';
        $params = [
            'isInScheme'      => 'http://data.europa.eu/esco/conceptScheme/skill', // the correct URI
            'language'        => 'en',
            'offset'          => 0,
            'limit'           => 10,
            'selectedVersion' => 'latest', // you can also try 'v1.1.1'
            'viewObsolete'    => 'true',
        ];

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Accept-Language' => 'en',
            ])->get($url, $params);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'ESCO API request failed',
                    'details' => $response->body(),
                ], $response->status());
            }

            $data = $response->json();

            return response()->json([
                'status' => 'success',
                'raw' => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Exception fetching ESCO skills',
                'message' => $e->getMessage(),
            ], 500);
        }
    }*/

    /*public function get_europa_skills()
    {
        // ESCO API endpoint details
        $skillsSchemeUri = 'http://data.europa.eu/esco/concept-scheme/skill';
        $baseUrl = 'https://ec.europa.eu/esco/api/resource/concept';
        $language = 'en';
        $offset = 0;
        $limit = 1000; // API typically allows paging with this default cap

        $allSkills = [];
        $client = new \GuzzleHttp\Client();

        do {
            try {
                $response = $client->get($baseUrl, [
                    'query' => [
                        'isInScheme' => $skillsSchemeUri,
                        'language' => $language,
                        'offset' => $offset,
                        'limit' => $limit,
                    ],
                    'headers' => [
                        'Accept' => 'application/json'
                    ]
                ]);
                $body = json_decode($response->getBody(), true);
                // Log response body for debugging


                // Continue with result extraction...
            } catch (\Exception $e) {

                return response()->json([
                    'total' => 0,
                    'skills' => [],
                    'error' => $e->getMessage(),
                ], 500);
            }


            $body = json_decode($response->getBody(), true);

            // If using HAL, look in '_embedded' > 'concepts'
            $results = isset($body['_embedded']['concepts']) ? $body['_embedded']['concepts'] : ($body['results'] ?? []);

            $allSkills = array_merge($allSkills, $results);

            $retrieved = count($results);
            $offset += $retrieved;

        } while ($retrieved === $limit);

        // Return array or JSON as required
        return response()->json([
            'total' => count($allSkills),
            'skills' => $allSkills
        ]);
    }*/

    public static function get_europa_skills(Request $request)
    {
        $baseUrl = 'https://ec.europa.eu/esco/api/resource/skill';
        $isInScheme = 'http://data.europa.eu/esco/concept-scheme/skills';
        $language = 'en';
        $selectedVersion = 'latest';
        $viewObsolete = 'false';
        $limit = $request->input('limit', 50);
        $offset = $request->input('offset', 0);

        $query = [
            'isInScheme' => $isInScheme,
            'language' => $language,
            'offset' => $offset,
            'limit' => $limit,
            'selectedVersion' => $selectedVersion,
            'viewObsolete' => $viewObsolete,
        ];

        $response = Http::retry(3, 2000)
            ->timeout(30)
            ->accept('application/json')
            ->get($baseUrl, $query);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'status' => $response->status(),
                'error' => $response->body(),
            ], 500);
        }

        $json = $response->json();
        $embedded = $json['_embedded'] ?? [];
        $titles = [];
        foreach ($embedded as $skill) {
            if (!empty($skill['title'])) {
                $titles[] = $skill['title'];
            }
        }

        return response()->json([
            'success' => true,
            'count' => count($titles),
            'offset' => $offset,
            'limit' => $limit,
            'titles' => $titles,
            'total' => $json['total'] ?? null,
        ]);
    }







}
