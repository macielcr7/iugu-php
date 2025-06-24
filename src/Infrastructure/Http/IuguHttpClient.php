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

    public function __construct(string $apiToken)
    {
        $this->apiToken = $apiToken;
        $this->baseUrl = 'https://api.iugu.com';
        $timeout = 10;
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $timeout,
            'auth' => [$this->apiToken, ''],
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
        try {
            return $this->client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new \Exception('Iugu API request error: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function get(string $uri, array $query = []): ResponseInterface
    {
        return $this->request('GET', $uri, ['query' => $query]);
    }

    public function post(string $uri, mixed $body = []): ResponseInterface
    {
        return $this->request('POST', $uri, ['json' => $this->convertToArray($body)]);
    }

    public function put(string $uri, mixed $body = []): ResponseInterface
    {
        return $this->request('PUT', $uri, ['json' => $this->convertToArray($body)]);
    }

    public function delete(string $uri, mixed $body = []): ResponseInterface
    {
        return $this->request('DELETE', $uri, ['json' => $this->convertToArray($body)]);
    }

    private function convertToArray(mixed $data): array
    {
        if (empty($data)) {
            return [];
        }
        return json_decode(json_encode($data), true);
    }
} 