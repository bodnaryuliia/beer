<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\FileParam;
use Acme\FooBundle\Validation\Constraints\MyComplexConstraint;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

use App\Service\BeerService;


class BeerRestApiController extends FOSRestController
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
     * Retrieves an Beer resource
     * @Rest\Get("/beers/{beerId}")
     *
     */
    public function getBeer(int $beerId)
    {
        $beer = $this->beerService->getBeer($beerId);

        if (!$beer) {
            throw new EntityNotFoundException('Beer with id ' . $beerId . ' does not exist!');
        }

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        $view = $this->view($beer, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * Retrieves a collection of Beers resource
     * @Rest\Get("/beers/brewer/{brewerId<\d+>?}")
     */
    public function getBeersByBrewer(int $brewerId)
    {
        $beers = $this->beerService->getBeersByBrewer($brewerId);

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
        $view = $this->view($beers, Response::HTTP_OK);
        return $this->handleView($view);
    }

    /**
     * Retrieves a collection of Beers resource
     * @QueryParam(name="brewer", nullable=true)
     * @QueryParam(name="name", nullable=true)
     * @QueryParam(name="fromprice", nullable=true)
     * @QueryParam(name="toprice", nullable=true)
     * @QueryParam(name="country", nullable=true)
     * @QueryParam(name="type", nullable=true)
     * @param ParamFetcher $paramFetcher
     * @Rest\Get("/beers")
     */
    public function getBeers(ParamFetcher $paramFetcher)
    {
        $params = $paramFetcher->all();

        if (array_filter($params)) {

            $beers = $this->beerService->getBeersByParameters($params);

        } else {

            $beers = $this->beerService->getAllBeers();

        }

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
        $view = $this->view($beers, Response::HTTP_OK);
        return $this->handleView($view);
    }
}
