<?php
/**
 * Created by PhpStorm.
 * User: Юля
 * Date: 21.10.2018
 * Time: 0:57
 */

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use App\Entity\Beers;
use App\Entity\Brewers;
use App\Entity\Countries;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

/*
{
    "product_id": 127031,
    "name": "Mad Jack Mixer",
    "size": "12  \u00d7  Can 355\u 00a0ml",
    "price": "23.95",
    "beer_id": 127,
    "image_url": "http://www.thebeerstore.ca/sites/default/files/styles/brand_hero/public/sbs/brand/18636-MJ-Family-Can-TBS-322x344.jpg?itok=v_mQRmR1",
    "category": "Domestic Specialty",
    "abv": "5.0",
    "style": "N/A",
    "attributes": "N/A",
    "type": "Lager",
    "brewer": "Molson",
    "country": "Canada",
    "on_sale": false
},

*/

class ParseCallApiResult
{
    protected $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function parse($data)
    {
        $parsedData = json_decode($data);

        $brewersRepository = $this->entityManager->getRepository(Brewers::class);
        $beersRepository = $this->entityManager->getRepository(Beers::class);
        $countriesRepository = $this->entityManager->getRepository(Countries::class);

        if ($parsedData) {
            foreach ($parsedData as $parsedElement) {

                $brewer = $brewersRepository->findOneBy(
                    ['name' => $parsedElement->brewer]
                );

                if ($brewer) {
                    $brewerId = $brewer->getId();
                } else {
                    $brewer = new Brewers();
                    $brewer->setName($parsedElement->brewer);
                    $this->entityManager->persist($brewer);
                    $this->entityManager->flush();
                    $brewerId = $brewer->getId();
                }

                $country = $countriesRepository->findOneBy(
                    ['name' => $parsedElement->country]
                );

                if ($country) {
                    $countryId = $country->getId();
                } else {
                    $country = new Countries();
                    $country->setName($parsedElement->country);
                    $country->setCode('code');
                    $this->entityManager->persist($country);
                    $this->entityManager->flush();
                    $countryId = $country->getId();
                }

                $beer = $beersRepository->findOneBy(
                    ['beerId' => $parsedElement->beer_id]
                );

                if (!$beer) {
                    $beer = new Beers();
                }

                $beer->setBrewerId($brewerId);
                $beer->setName($parsedElement->brewer);
                $beer->setType($parsedElement->type);
                $beer->setBeerId($parsedElement->beer_id);
                $beer->setPrice($parsedElement->price);
                $beer->setCountryId($countryId);

                $this->entityManager->persist($beer);
                $this->entityManager->flush();

                unset($beer, $country, $brewer);

            }
        }

    }

}