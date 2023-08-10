<?php

/**
 * Интерфейс к сервису кэша (имплементировать класс не нужно)
 */
interface Cache
{
    /**
     * @param int[] $ids
     *
     * @return array<int,Item|null>
     */
    public function get(array $ids): array;

    /**
     * @param array<int,Item> $items
     */
    public function set(array $items): void;
}

/**
 * Интерфейс к http-клиенту сервиса объявлений (имплементировать класс не нужно)
 */
interface Client
{
    /**
     * @param int[] $ids
     *
     * @return array<int,Item>
     */
    public function get(array $ids): array;
}

/**
 * Класс служит обёрткой над http-клиентом к сервису, хранящему информацию об объявлениях.
 * Метод `getByIds`, принимает массив идентификаторов и возвращающий массив найденных сущностей Item.
 * Нужно дополнить метод `getByIds`, чтобы он мог использовать кэш.
 */
class ItemService
{
    public function __construct(private Client $client)
    {
    }

    /**
     * @param int[] $ids
     *
     * @return array<int,Item>
     */
    public function getByIds(array $ids): array
    {
        // @todo Написать логику работы с кешом
        return $this->client->get($ids);
    }
}