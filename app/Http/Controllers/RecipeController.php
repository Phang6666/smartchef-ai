<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str; // Make sure to import Str

class RecipeController extends Controller
{
    /**
     * Display the homepage with the ingredient form.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Handle the form submission and call the Gemini API.
     */
    public function generate(Request $request)
    {
        // 1. Validate the user's input
        $request->validate([
            'ingredients' => 'required|string|min:5',
        ]);

        $ingredients = $request->input('ingredients');
        $apiKey = config('services.gemini.api_key');

        // ** GOING BACK TO THE CORRECT API URL **
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro-latest:generateContent?key={$apiKey}";

        // The prompt for the Gemini API
        $prompt = "You are a creative chef. Generate a recipe using the following ingredients: {$ingredients}.
        Include the following sections:
        - A creative 'Recipe Name'
        - 'Estimated Cooking Time' in minutes
        - An 'Ingredients List' with quantities
        - 'Step-by-step Cooking Instructions'
        - An estimated 'Calorie Count'.
        Format the entire response in clean Markdown.";

        // The correct data structure for the Gemini API
        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ]
        ];

        // The HTTP call with our SSL fix
        $response = Http::withOptions(['verify' => 'C:\\wamp64\\bin\\php\\php7.4.33\\extras\\ssl\\cacert.pem'])
                        ->post($url, $data);

        // Handle the response
        if ($response->successful()) {
            $recipeText = $response->json('candidates.0.content.parts.0.text');
            return view('welcome', ['recipe' => $recipeText]);
        } else {
            $error = "Failed to generate recipe. The API returned an error: " . $response->body();
            return view('welcome', ['error' => $error]);
        }
    }
}