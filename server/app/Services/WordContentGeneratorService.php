<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WordContentGeneratorService
{

  private $apiKey;

  public function __construct()
  {
    $this->apiKey = env('GEMINI_KEY'); // Defina sua chave da API no .env
  }


  private function fetch(string $word): array
  {

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent?key=' . $this->apiKey;


    $body = [
      "contents" => [
        [
          "role" => "user",
          "parts" => [
            [
              "text" => $word
            ]
          ]
        ]
      ],
      "systemInstruction" => [
        "role" => "user",
        "parts" => [
          [
            "text" => "Você é um dicionário de português do Brasil. Quando receber uma consulta, retorne UM OBJETO JSON seguindo EXATAMENTE o schema abaixo. Não adicione textos extras.\n\nCampos obrigatórios:\n\n- word: A palavra consultada.\n- wordBase: A forma básica da palavra, sem alterações (ex.: \"correr\", não \"corri\").\n- partOfSpeech: Tipo completo da palavra, incluindo classificações detalhadas (ex.: \"verbo transitivo direto\", \"substantivo masculino\", \"adjetivo de dois gêneros\").\n- meanings: Todos os significados da palavra, tanto os do dicionário quanto os populares. Se os contextos ou explicações forem próximos, combine-os em um único contexto mais amplo. Cada item deve ter:\n  - title: Contexto ou tipo de significado (ex.: \"mineração\" para \"mina\").\n  - explanation: Explicação simples, direta e fácil de entender, sem termos técnicos ou palavras difíceis.\n- synonyms: Lista de sinônimos (palavras com o mesmo significado). Máximo de 5 palavras. Pode ser vazio.\n- antonyms: Lista de antônimos (palavras com significado oposto). Máximo de 5 palavras. Pode ser vazio.\n- isExist: Indica se a palavra existe no dicionário (true ou false).\n\nRegras:\n- Retorne somente o JSON, sem texto extra.\n- As definições devem ser **muito simples e fáceis de entender**.\n- Não use palavras difíceis ou linguagem técnica.\n- Liste TODOS os significados da palavra, incluindo tanto os formais quanto os populares. Se contextos forem parecidos, combine-os.\n- `partOfSpeech` deve sempre conter a classificação completa da palavra, sem abreviações.\n"
          ]
        ]
      ],
      "generationConfig" => [
        "temperature" => 0.3,
        "topK" => 40,
        "topP" => 0.95,
        "maxOutputTokens" => 8192,
        "responseMimeType" => "application/json",
        "responseSchema" => [
          "type" => "object",
          "properties" => [
            "word" => [
              "type" => "string",
              "description" => "A palavra consultada."
            ],
            "wordBase" => [
              "type" => "string",
              "description" => "Forma básica da palavra, sem mudanças."
            ],
            "partOfSpeech" => [
              "type" => "string",
              "description" => "Tipo completo da palavra, incluindo classificações detalhadas (ex.: 'verbo transitivo direto', 'substantivo masculino')."
            ],
            "meanings" => [
              "type" => "array",
              "description" => "Lista de todos os significados da palavra, incluindo significados do dicionário e populares. Se contextos forem parecidos, combine-os.",
              "items" => [
                "type" => "object",
                "properties" => [
                  "title" => [
                    "type" => "string",
                    "description" => "Contexto ou tipo de significado."
                  ],
                  "explanation" => [
                    "type" => "string",
                    "description" => "Explicação simples, direta e fácil de entender, sem palavras difíceis."
                  ]
                ],
                "required" => [
                  "title",
                  "explanation"
                ]
              ]
            ],
            "synonyms" => [
              "type" => "array",
              "description" => "Sinônimos. Máximo de 5 palavras.",
              "items" => [
                "type" => "string"
              ]
            ],
            "antonyms" => [
              "type" => "array",
              "description" => "Antônimos. Máximo de 5 palavras.",
              "items" => [
                "type" => "string"
              ]
            ],
            "isExist" => [
              "type" => "boolean",
              "description" => "Indica se a palavra existe (true ou false)."
            ]
          ],
          "required" => [
            "word",
            "wordBase",
            "partOfSpeech",
            "meanings",
            "isExist"
          ]
        ]
      ]
    ];

    $response = Http::retry(3, 300)->throw()->post($url, $body);

    $response = $response->json();

    $wordContentJson = $response['candidates'][0]['content']['parts'][0]['text'];

    return json_decode($wordContentJson, true);
  }

  /**
   * @return array{
   *     word: string,
   *     wordBase: string,
   *     partOfSpeech: string,
   *     meanings: array<array{ title: string, explanation: string }>,
   *     synonyms: string[],
   *     antonyms: string[],
   *     isExist: bool
   * }
   */
  public function generate(string $word): array
  {
    $wordContent = $this->fetch($word);


    return $wordContent;
  }
}
