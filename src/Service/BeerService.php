<?php
/**
 * Created by PhpStorm.
 * User: Юля
 * Date: 22.10.2018
 * Time: 12:42
 */

namespace App\Service;

use App\Repository\BeersRepository;
use App\Entity\Beers;

class BeerService
{
    protected $entityManager;
    protected $objectRepository;

    public function __construct($entityManager)
    {
       $this->entityManager = $entityManager;
       $this->objectRepository = $this->entityManager->getRepository(Beers::class);
    }

    public function getBeer(int $beerId)
    {
        return $this->objectRepository->find($beerId);
    }

    public function getAllBeers()
    {
        return $this->objectRepository->findAll();
    }

    public function getBeersByParameters($params)
    {
         return $this->objectRepository->findByFields($params);
    }

}