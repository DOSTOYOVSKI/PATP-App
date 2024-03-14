<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $sexe = $request->query('sexe');
        $urlMostFamous1900 = 'https://angersloiremetropole.opendatasoft.com/api/explore/v2.1/catalog/datasets/prenoms-des-enfants-nes-a-angers/records?where=annee%20%3E%201900';
        $urlMostFamous2015 = 'https://angersloiremetropole.opendatasoft.com/api/explore/v2.1/catalog/datasets/prenoms-des-enfants-nes-a-angers/records?where=annee%20%3E%202015&order_by=nombre_occurrences%20DESC&limit=-1';
        $urlLastYear = 'https://angersloiremetropole.opendatasoft.com/api/explore/v2.1/catalog/datasets/prenoms-des-enfants-nes-a-angers/records?where=annee%20%3D%202023&order_by=nombre_occurrences%20DESC&limit=1';
        $urlMostTop10 = 'https://angersloiremetropole.opendatasoft.com/api/explore/v2.1/catalog/datasets/prenoms-des-enfants-nes-a-angers/records?where=annee%20%3E%202018&order_by=nombre_occurrences%20DESC&limit=-1';

        if ($sexe) {
            $urlMostFamous1900 = 'https://angersloiremetropole.opendatasoft.com/api/explore/v2.1/catalog/datasets/prenoms-des-enfants-nes-a-angers/records?where=annee%20%3E%202015%20AND%20enfant_sexe%20%3D%20%22' . $sexe . '%22';
            $urlMostFamous2015 = 'https://angersloiremetropole.opendatasoft.com/api/explore/v2.1/catalog/datasets/prenoms-des-enfants-nes-a-angers/records?where=annee%20%3E%202015AND%20enfant_sexe%20%3D%20%22' . $sexe .'%22&order_by=nombre_occurrences%20DESC&limit=-1';
            $urlLastYear = 'https://angersloiremetropole.opendatasoft.com/api/explore/v2.1/catalog/datasets/prenoms-des-enfants-nes-a-angers/records?where=annee%20%3D%202023AND%20enfant_sexe%20%3D%20%22' . $sexe .'%22&order_by=nombre_occurrences%20DESC&limit=1';
            $urlMostTop10 = 'https://angersloiremetropole.opendatasoft.com/api/explore/v2.1/catalog/datasets/prenoms-des-enfants-nes-a-angers/records?where=annee%20%3E%202018AND%20enfant_sexe%20%3D%20%22' . $sexe .'%22&order_by=nombre_occurrences%20DESC&limit=-1';
        }
        $response = Http::get($urlMostFamous1900);
        $responseTwo = Http::get($urlMostFamous2015);
        $responseThree = Http::get($urlLastYear);
        $responseTop10 = Http::get($urlMostTop10);

        if ($response->ok()) {
            $data = $response->json();

            $prenoms = [];

            foreach ($data['results'] as $result) {
                $prenom = $result['enfant_prenom'];
                $nombreOccurrences = $result['nombre_occurrences'];

                // Increment occurrences for 1900 data
                if (isset($prenoms[$prenom])) {
                    $prenoms[$prenom] += $nombreOccurrences;
                } else {
                    $prenoms[$prenom] = $nombreOccurrences;
                }
            }

            $prenomLePlusUtilise = null;
            $nombreOccurrencesMax = 0;

            foreach ($prenoms as $prenom => $nombreOccurrences) {
                if ($nombreOccurrences > $nombreOccurrencesMax) {
                    $prenomLePlusUtilise = $prenom;
                    $nombreOccurrencesMax = $nombreOccurrences;
                }
            }
        }

        if ($responseTwo->ok()) {
            $dataTwo = $responseTwo->json();

            $prenomsTwo = [];

            foreach ($dataTwo['results'] as $result) {
                $prenom = $result['enfant_prenom'];
                $nombreOccurrences = $result['nombre_occurrences'];

                // Increment occurrences for 2015 data (separate variables)
                if (isset($prenomsTwo[$prenom])) {
                    $prenomsTwo[$prenom] += $nombreOccurrences;
                } else {
                    $prenomsTwo[$prenom] = $nombreOccurrences;
                }
            }

            $prenomLePlusUtilise2015 = null;
            $nombreOccurrencesMax2015 = 0;

            foreach ($prenomsTwo as $prenom => $nombreOccurrences) {
                if ($nombreOccurrences > $nombreOccurrencesMax2015) {
                    $prenomLePlusUtilise2015 = $prenom;
                    $nombreOccurrencesMax2015 = $nombreOccurrences;
                }
            }
        }
        $dataThree = $responseThree->json();
        $prenom2023 = ($dataThree['results'][0]['enfant_prenom']);
        $nbOcc2023 = ($dataThree['results'][0]['nombre_occurrences']);

        if ($responseTop10->ok()) {
            $prenoms = [];

// Parcourir les résultats
            foreach ($data['results'] as $result) {
                $prenom = $result['enfant_prenom'];
                $nombreOccurrences = $result['nombre_occurrences'];

                // Incrémenter le nombre d'occurrences du prénom
                if (isset($prenoms[$prenom])) {
                    $prenoms[$prenom] += $nombreOccurrences;
                } else {
                    $prenoms[$prenom] = $nombreOccurrences;
                }
            }

// Trier les prénoms par nombre d'occurrences décroissantes
            arsort($prenoms);

// Extraire les 10 prénoms les plus utilisés
            $prenomsTop10 = array_slice($prenoms, 0, 10);
        }
        if($responseTop10->ok()) {
            $prenoms = [];

// Parcourir les résultats
            foreach ($data['results'] as $result) {
                $prenom = $result['enfant_prenom'];
                $nombreOccurrences = $result['nombre_occurrences'];

                // Incrémenter le nombre d'occurrences du prénom
                if (isset($prenoms[$prenom])) {
                    $prenoms[$prenom] += $nombreOccurrences;
                } else {
                    $prenoms[$prenom] = $nombreOccurrences;
                }
            }

// Trier les prénoms par nombre d'occurrences croissantes
            asort($prenoms);

// Extraire les 10 prénoms les plus rares
            $prenomsTop10Rares = array_slice($prenoms, 0, 10);
        }

        return view('welcome', [
            'famousName' => $prenomLePlusUtilise,
            'nbOccurence' => $nombreOccurrencesMax,
            'famousName2015' => $prenomLePlusUtilise2015,
            'nbOccurence2015' => $nombreOccurrencesMax2015,
            'famousName2023' => $prenom2023,
            'nbOccurence2023' => $nbOcc2023,
            'top10' => $prenomsTop10,
            'topRare' => $prenomsTop10Rares,
            'sexe' => $sexe,
        ]);
    }
}
