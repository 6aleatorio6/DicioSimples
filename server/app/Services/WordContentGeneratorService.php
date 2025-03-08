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
            "text" => "Você é um dicionário de português do Brasil. Ao receber uma consulta, retorne um **objeto JSON** que siga **exatamente** o schema abaixo. Não adicione texto extra, apenas o JSON.\n\n**Regras:**\n- As definições devem ser **claras e de fácil leitura**.\n- **Evite palavras difíceis ou termos técnicos**, prefira palavras fáceis e populares.\n- Liste **todos os significados da palavra**, incluindo usos formais e populares. **Se contextos forem parecidos, combine-os**.\n- `partOfSpeech` deve conter **a classificação completa**, sem abreviações.\n- Máximo de **5 sinônimos e 5 antônimos**, cada um com **apenas uma palavra**, sem espaços ou gírias compostas.\n- `title` dentro de `meanings` deve ser **apenas uma palavra ou nome**, representando o contexto da explicação.\n- Cada explicação deve ter um contexto, indicado pelo campo `title`.\n- `wordBase` deve ser **o lema da palavra consultada** (ex.: `word: pamonhas`, `wordBase: pamonha`).\n- A explicação deve ser **coerente e de fácil leitura**, utilizando palavras fáceis e populares, sem ser vaga ou excessivamente ampla.\n- As explicações dentro de `meanings` devem ser **ordenadas das mais populares para as menos conhecidas**.\n\n"
          ]
        ]
      ],
      "generationConfig" => [
        "temperature" => 0.5,
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
              "description" => "O lema da palavra consultada (ex.: 'pamonhas' → 'pamonha')."
            ],
            "partOfSpeech" => [
              "type" => "string",
              "description" => "Classificação completa da palavra (ex.: 'verbo transitivo direto', 'substantivo masculino')."
            ],
            "meanings" => [
              "type" => "array",
              "description" => "Lista de todos os significados, incluindo formais e populares. Se forem parecidos, combine-os. Ordenados das mais populares para as menos conhecidas.",
              "items" => [
                "type" => "object",
                "properties" => [
                  "title" => [
                    "type" => "string",
                    "description" => "Contexto da explicação (apenas uma palavra ou nome)."
                  ],
                  "explanation" => [
                    "type" => "string",
                    "description" => "Explicação coerente e de fácil leitura, utilizando palavras fáceis e populares, sem ser vaga ou excessivamente ampla."
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
              "description" => "Sinônimos (máximo de 5, cada item deve ser uma palavra única, sem espaços ou gírias compostas). Pode estar vazio.",
              "items" => [
                "type" => "string"
              ]
            ],
            "antonyms" => [
              "type" => "array",
              "description" => "Antônimos (máximo de 5, cada item deve ser uma palavra única, sem espaços ou gírias compostas). Pode estar vazio.",
              "items" => [
                "type" => "string"
              ]
            ],
            "isExist" => [
              "type" => "boolean",
              "description" => "Indica se a palavra existe no dicionário (true ou false)."
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
