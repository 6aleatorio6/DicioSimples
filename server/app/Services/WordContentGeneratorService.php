<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WordContentGeneratorService
{

  private $requestUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=";

  function __construct()
  {
    $this->requestUrl .= env('GEMINI_KEY');
  }


  /**
   * @return array{
   *     word: string,
   *     wordBase: string,
   *     meanings: array<array{title: string, explanation: string}>,
   *     synonyms: string[],
   *     antonyms: string[]
   * }
   */
  public function generate(string $word): array
  {
    $response = Http::retry(3, 300)->throw()->post($this->requestUrl, $this->getRequestBody($word));

    $response = $response->json();

    $wordContentJson = $response['candidates'][0]['content']['parts'][0]['text'];

    return json_decode($wordContentJson, true);
  }


  private function getRequestBody(string $word): array
  {
    return [
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
            "text" => "Você atua como um dicionário abrangente que cobre palavras formais, informais e gírias populares. Ao receber uma palavra, retorne um objeto JSON contendo informações detalhadas e precisas, obedecendo estritamente o schema especificado. Siga as regras abaixo:\n\nUtilize somente definições provenientes de dicionários oficiais ou amplamente reconhecidos.\nPara gírias, adote definições comumente aceitas na linguagem popular.\nSe a palavra possuir múltiplos significados, liste todos no campo \"meanings\", explicando detalhadamente cada significado, incluindo nuances, exemplos e contextos de uso sempre que disponíveis.\nCaso a palavra seja uma flexão, descreva as variações em relação à forma base, detalhando as diferenças de uso e os contextos específicos em que cada forma é empregada.\nSe a palavra tiver uso informal ou for uma gíria, inclua uma explicação clara sobre esse aspecto.\nResponda apenas em JSON, sem comentários ou textos adicionais.\nSiga rigorosamente o schema especificado: inclua somente os campos e tipos determinados, sem adicionar campos extras.\nSe alguma informação não estiver disponível, retorne valores vazios (\"\" para strings e [] para arrays), sem suposições.\nCertifique-se de que o JSON esteja válido e siga exatamente o schema antes de enviar a resposta.\nSua tarefa é explicar todos os significados que uma palavra pode ter, ressaltando as diferenças entre eles e detalhando as variações de uso quando a palavra é uma flexão."
          ]
        ]
      ],
      "generationConfig" => [
        "temperature" => 0.7,
        "topK" => 64,
        "topP" => 0.95,
        "maxOutputTokens" => 8192,
        "responseMimeType" => "application/json",
        "responseSchema" => [
          "type" => "object",
          "properties" => [
            "word" => [
              "type" => "string",
              "description" => "A palavra consultada, conforme inserida na pesquisa do dicionário."
            ],
            "wordBase" => [
              "type" => "string",
              "description" => "A forma canônica ou raiz da palavra. Se a palavra consultada for uma flexão, este campo indica sua forma base."
            ],
            "meanings" => [
              "type" => "array",
              "description" => "Lista de todos os significados da palavra, conforme definidos em fontes oficiais ou amplamente reconhecidos. Cada entrada deve conter um título e uma explicação detalhada.",
              "items" => [
                "type" => "object",
                "properties" => [
                  "title" => [
                    "type" => "string",
                    "description" => "Rótulo ou identificação do significado, especialmente útil quando há mais de uma definição para a palavra."
                  ],
                  "explanation" => [
                    "type" => "string",
                    "description" => "Explicação clara, detalhada e simplificada do significado, utilizando vocabulário acessível e fundamentado em dicionários oficiais."
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
              "description" => "Lista de palavras ou expressões que possuem significados semelhantes à palavra consultada.",
              "items" => [
                "type" => "string"
              ]
            ],
            "antonyms" => [
              "type" => "array",
              "description" => "Lista de palavras ou expressões que possuem significados opostos à palavra consultada.",
              "items" => [
                "type" => "string"
              ]
            ]
          ],
          "required" => [
            "word",
            "wordBase",
            "meanings",
            "synonyms",
            "antonyms"
          ]
        ]
      ]
    ];
  }
}
