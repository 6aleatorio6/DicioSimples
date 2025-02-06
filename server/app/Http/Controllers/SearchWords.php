<?php

namespace App\Http\Controllers;

use App\Jobs\RequestWordSuggestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use PhpParser\Node\Stmt\TryCatch;

class SearchWords extends Controller
{

    function __construct(
        private Http $http,
        private Log $log
    ) {}

    public function  show(Request $request,)
    {
        $search = $request->query('s');


        return Inertia::render('Public/SearchWords', [
            'resultSearch' => $search ? $this->getSuggestions($search) : null,
        ]);
    }

    private function getSuggestions($search)
    {
        $response = $this->requestSuggestions($search);




        return collect($response->result)->map(function ($item) {
            [$word, $word_flexion] = $item;

            return $word_flexion->form ?? $word;
        })->all();
    }




    private function requestSuggestions($search)
    {
        $API_KEY = "AIzaSyBRNaLafv8EqhDZdCmonvyA4UdpxjOgO5A";
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key={$API_KEY}";


        $data = [
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        [
                            "text" => $search
                        ]
                    ]
                ]
            ],
            "systemInstruction" => [
                "role" => "user",
                "parts" => [
                    [
                        "text" => "Você é um sistema de autocomplete de palavras para um dicionário de português. Sua função é sugerir palavras completas a partir de entradas parciais fornecidas pelo usuário, ignorando palavras conectores (como preposições, artigos e conjunções).\n\nVocê deve:\n\n- Aceitar pequenos erros de digitação (letras faltando, trocadas ou duplicadas).  \n- Retornar um JSON estruturado com a lista de sugestões de palavras completas.  \n- Para palavras flexionadas, identificar a forma flexionada e fornecer metadados, como tempo verbal, modo, pessoa, pluralidade e gênero, conforme aplicável.  \n- Se não houver palavras suficientemente parecidas com a entrada, retornar `{ query: <entrada>, result: [] }`.\n\nTodas as próximas perguntas feitas ao sistema serão consideradas consultas (queries) de entradas parciais.\n\n**Formato de saída esperado:**\n\n```json\n{\n  \"query\": \"<entrada fornecida>\",\n  \"result\": [\n    [\n      \"<palavra>\",\n      {\n        \"form\": \"<forma flexionada>\",\n        \"mood\": \"indicative | subjunctive | imperative\",\n        \"tense\": \"present | past | future\",\n        \"person\": 1 | 2 | 3,\n        \"isPlural\": true | false,\n        \"gender\": \"masculine | feminine | neutral\"\n      }\n    ]\n  ]\n}\n```\n\n**Exemplo de entrada e saída:**\n\nEntrada: `\"comeram\"`  \nSaída:  \n```json\n{\n  \"query\": \"comeram\",\n  \"result\": [\n    [\n      \"comer\",\n      {\n        \"form\": \"comeram\",\n        \"mood\": \"indicative\",\n        \"tense\": \"past\",\n        \"person\": 3,\n        \"isPlural\": true\n      }\n    ]\n  ]\n}\n```\n\nEntrada: `\"livr\"`  \nSaída:  \n```json\n{\n  \"query\": \"livr\",\n  \"result\": [\n    [\"livro\", {}],\n    [\"livros\", { \"form\": \"livros\", \"isPlural\": true }],\n    [\"livraria\", {}]\n  ]\n}\n```\n\nEntrada: `\"abcxyz\"`  \nSaída:  \n```json\n{\n  \"query\": \"abcxyz\",\n  \"result\": []\n}\n```\n\n**Regras:**\n1. Ignore palavras conectores, como \"de\", \"a\", \"o\", \"para\", etc.  \n2. Aceite pequenos erros de digitação.  \n3. Retorne o JSON especificado, mesmo para casos sem sugestões (`result: []`).  \n4. Sugestões devem ser corretas em português e limitadas a 5 resultados.\n\n"
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 0.4,
                "topK" => 40,
                "topP" => 0.6,
                "maxOutputTokens" => 8192,
                "responseMimeType" => "application/json"
            ]
        ];

        $responseJson = Http::retry(4, 250)->post($url, $data)->throw()->json();
        $result = $responseJson['candidates'][0]['content']['parts'][0]['text'];


        return json_decode($result);
    }
}
