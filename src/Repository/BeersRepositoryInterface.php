<?php

namespace App\Repository;

/**
 * Interface BeersRepositoryInterface
 * @package App\Repository
 */
interface BeersRepositoryInterface
{
    /**
     * @param int $beerId
     * @return Beers
     */
    public function findById(int $beerId): ?Beers;

    /**
     * @return array
     */
    public function findAll(): array;

}