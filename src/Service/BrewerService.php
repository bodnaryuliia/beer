<?php
/**
 * Created by PhpStorm.
 * User: Юля
 * Date: 22.10.2018
 * Time: 10:31
 */

namespace App\Service;

use App\Repository\BrewersRepository;
use App\Entity\Brewers;

class BrewerService
{
    protected $entityManager;
    protected $objectRepository;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Brewers::class);
    }

    public function getAllBrewers(): ?array
    {
        return $this->objectRepository->findAll();
    }
}