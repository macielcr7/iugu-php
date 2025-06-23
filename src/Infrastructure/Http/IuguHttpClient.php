<?php

declare(strict_types=1);

namespace Iugu\Infrastructure\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class IuguHttpClient
{
    private Client $client;
    private string $apiToken;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiToken = config('iugu.api_token');
        $this->baseUrl = rtrim(config('iugu.base_url'), '/') . '/';
        $timeout = config('iugu.timeout', 10);
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $timeout,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * @throws \Exception
     */
    public function request(string $method, string $uri, array $options = []): ResponseInterface
    {
        $options['query']['api_token'] = $this->apiToken;
        try {
            return $this->client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new \Exception('Erro na requisição à API Iugu: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function get(string $uri, array $query = []): ResponseInterface
    {
        return $this->request('GET', $uri, ['query' => $query]);
    }

    public function post(string $uri, array $body = []): ResponseInterface
    {
        return $this->request('POST', $uri, ['json' => $body]);
    }

    public function put(string $uri, array $body = []): ResponseInterface
    {
        return $this->request('PUT', $uri, ['json' => $body]);
    }

    public function delete(string $uri, array $body = []): ResponseInterface
    {
        return $this->request('DELETE', $uri, ['json' => $body]);
    }
} 