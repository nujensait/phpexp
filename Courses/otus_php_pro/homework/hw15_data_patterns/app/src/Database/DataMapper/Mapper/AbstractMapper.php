<?php

namespace App\Db\Database\DataMapper\Mapper;

use App\Db\Database\DataMapper\Entity\Company;
use App\Db\Database\Entity;
use App\Db\Database\QueryBuilder;

interface AbstractMapper
{
    public function __construct(QueryBuilder $queryBuilder);
    public function insert(Entity $entity): int;
    public function update(Entity $entity): void;
    public function delete(Entity $entity): void;
    public function findById(int $id): ?Company;
    public function findAll(): array;
}
