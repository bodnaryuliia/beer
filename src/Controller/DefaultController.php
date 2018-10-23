<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Beers;
use App\Entity\Brewers;

use App\Service\BeerService;

class DefaultController extends AbstractController
{

    /**
     * @var BeerService
     */
    private $beerService;

    /**
     * BeerRestApiController constructor.
     * @param BeerService $beerService
     */
    public function __construct(BeerService $beerService)
    {
        $this->beerService = $beerService;
    }

    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $dataBeers = array();
        $dataBrewers = array();

        $beers = $this->beerService->getAllBeers();

        if (is_array($beers) && !empty($beers)) {

            $dataBrewersArray = array();

            foreach ($beers as $beer) {

                $brewer = $beer->getBrewId();

                $dataBrewersArray[$brewer->getId()] = $brewer->getName();

                $dataBeers[] = array(
                    "brewer" => $brewer->getId(),
                    "name" => $beer->getName(),
                    "price" => $beer->getPrice(),
                    "country" => $beer->getCountryId(),
                    "type" => $beer->getType(),
                );
            }

            foreach ($dataBrewersArray as $dataBrewersKey => $dataBrewersValue) {
                $dataBrewers[] = array(
                    "brewerId" => $dataBrewersKey,
                    "brewerName" => $dataBrewersValue,
                );
            }

        }

        return $this->render(
            'index.html.twig',
            array(
                'dataBeers' => json_encode($dataBeers),
                'dataBrewers' => json_encode($dataBrewers),
            )
        );
    }
}
