<?php

namespace App\Service;

use League\Csv\Writer;
use function array_filter;
use function parse_url;
use const PHP_URL_HOST;
use Psr\Log\LoggerInterface;
use function str_starts_with;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;

final class LinkChecker
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function checkUrl(string $url): void
    {
        $csv = Writer::createFromPath('links.csv', 'wr+');
        $csv->insertOne(['url', 'statuscode']);

        foreach ($this->getExternalLinks($url) as $link) {
            $statusCode = $this->getResponseCode($link);

            $host = parse_url($link, PHP_URL_HOST);

            if ($statusCode !== Response::HTTP_OK) {
                $csv->insertOne([$link, $statusCode]);

                $this->logger->warning($link, [
                    'code' => $statusCode,
                    'host' => $host,
                ]);
            }
        }
    }

    private function getResponseCode(mixed $link): ?int
    {
        $client = HttpClient::create();
        $request = $client->request('GET', $link);
        try {
            return $request->getStatusCode();
        } catch (TransportException) {
            return null;
        }
    }

    /**
     * @return mixed[]
     */
    private function getExternalLinks(string $url): array
    {
        return array_filter($this->getLinks($url), fn (string $url) => str_starts_with($url, 'https://') || str_starts_with($url, 'http://'));
    }

    /**
     * @return mixed[]
     */
    private function getLinks(string $url): array
    {
        $crawler = $this->getCrawler($url);

        return $crawler
            ->filter('a')
            ->each(static fn (Crawler $node, $i) => $node->attr('href'));
    }

    private function getCrawler(string $url): Crawler
    {
        $browser = new HttpBrowser(HttpClient::create());

        return $browser->request('GET', $url);
    }
}
