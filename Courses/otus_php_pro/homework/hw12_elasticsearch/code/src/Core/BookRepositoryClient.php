<?php

declare(strict_types=1);

namespace Otus\App\Core;

use Otus\App\Entity\Book;
use Otus\App\Entity\Stock;

/**
 * ElasticSearch client
 */
class BookRepositoryClient extends DataRepositoryClient
{
    /**
     * @param array $result
     * @return array
     */
    public function formatResult(array $result): array
    {
        $preparedResult = [];
        foreach ($result as $bookInfo) {
            $book = new Book(
                book_dto: new BookDTO(
                    sku: $bookInfo['_source']['sku'],
                    title: $bookInfo['_source']['title'],
                    category: $bookInfo['_source']['category'],
                    price: $bookInfo['_source']['price']
                )
            );
            foreach ($bookInfo['_source']['stock'] as $stockInfo) {
                $book->addStock(new Stock($stockInfo['shop'], $stockInfo['stock']));
            }
            $preparedResult[] = $book;
        }
        return $preparedResult;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getPreparedParams(array $params): array
    {
        $conditions = [];
        foreach ($params as $name => $value) {
            switch ($name) {
                case 'title':
                    $conditions['match'][$name] = [
                        'query' => $value,
                        'fuzziness' => 'auto',
                    ];
                    break;
                case 'sku':
                case 'category':
                    $conditions['term'][$name] = [
                        'value' => $value,
                    ];
                    break;
                case 'in_stock':
                    $conditions['nested'] = [
                        'path' => 'stock',
                        'query' => [
                            [
                                'range' => [
                                    'stock.stock' => [
                                        'gt' => '0',
                                    ],
                                ],
                            ],
                            [
                                'term' => [
                                    'stock.shop' => [
                                        'value' => $value,
                                    ],
                                ],
                            ],
                        ],
                    ];
                    break;
                case 'price_from':
                    if (!$value) {
                        break;
                    }
                    $conditions['range']['price'] = [
                        'gte' => $value,
                    ];
                    break;
                case 'price_to':
                    if (!$value) {
                        break;
                    }
                    $conditions['range']['price'] = [
                        'lte' => $value,
                    ];
                    break;
                case 'limit':
                    $limit = (int)$value;
                    break;
                case 'offset':
                    $offset = (int)$value;
            }
        }

        if (empty($conditions)) {
            $conditions = [
                'match_all' => (object)[],
            ];
        }

        return [
            'index' => 'otus-shop',
            'body' => [
                'size' => $limit ?? self::LIMIT,
                'from' => $offset ?? 0,
                'query' => $conditions,
            ],
        ];
    }
}
