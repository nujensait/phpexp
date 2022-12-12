<?php

declare(strict_types=1);

namespace Otus\App\Core;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

/**
 * Data repository client
 */
abstract class DataRepositoryClient implements RepositoryInterface
{
    protected const LIMIT = 10;       // output limit default
    protected Client $client;         // Elastic client

    /**
     * @throws \Elastic\Elasticsearch\Exception\AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();
    }

    /**
     * @param array $params
     * @return array
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function search(array $params): array
    {
        $preparedParams = $this->getPreparedParams($params);
        $response = $this->client->search($preparedParams);
        $responseAsArray = $response->asArray()['hits']['hits'];

        return $this->formatResult($responseAsArray);
    }
}
