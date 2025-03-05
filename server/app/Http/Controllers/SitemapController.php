<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator as URL;
use Illuminate\Contracts\Cache\Repository as Cache;
use SimpleXMLElement;


class SitemapController extends Controller
{
    public function __invoke(URL $url, Word $wordModel, Cache $cache)
    {
        $cacheKey = 'sitemap.xml';

        // Verificar se o sitemap já está em cache
        $sitemap = $cache->get($cacheKey);

        if (!$sitemap) {
            // Gerar o sitemap dinamicamente se não estiver em cache
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
            $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

            // Página de busca
            $this->addUrlToSitemap($xml, $url->route('home'), Carbon::now());

            // Páginas das palavras - Buscar por chunks
            $wordModel->whereNotNull('meanings')->select('word', 'updated_at')
                ->chunk(500, function ($words) use ($xml, $url) {
                    foreach ($words as $word) {
                        $this->addUrlToSitemap(
                            $xml,
                            $url->route('word', ['word' => $word->word]),
                            $word->updated_at
                        );
                    }
                });

            // Armazenar o sitemap em cache por 24 horas
            $sitemap = $xml->asXML();
            $cache->put($cacheKey, $sitemap, now()->addDay());
        }

        // Retornar o XML gerado ou em cache
        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function addUrlToSitemap(SimpleXMLElement $xml, string $loc, Carbon $lastmod)
    {
        $urlTag = $xml->addChild('url');
        $urlTag->addChild('loc', $loc);
        $urlTag->addChild('lastmod', $lastmod->toAtomString());
        $urlTag->addChild('changefreq', 'monthly');
        $urlTag->addChild('priority', '1.0');
    }
}
