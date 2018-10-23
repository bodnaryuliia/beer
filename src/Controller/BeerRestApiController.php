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
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerBuilder;

use App\Service\BeerService;
use App\Service\BrewerService;


class BeerRestApiController extends FOSRestController
{
    /**
     * @var BeerService
     */
    private $brewerService;
    private $beerService;

    /**
     * BeerRestApiController constructor.
     * @param BeerService $beerService
     */
    public function __construct(BeerService $beerService, BrewerService $brewerService)
    {
        $this->brewerService = $brewerService;
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
        //return View::create($beer, Response::HTTP_CREATED);

        //TODO edit this code/ Here is serialized in wrong way
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $serializer = new Serializer(array($normalizer), array($encoder));
        $json = $serializer->serialize($beer, 'json');

        $view = $this->view($json, 200);

        return $this->handleView($view);
    }

    /**
     * Retrieves a collection of Beers resource
     * @Rest\Get("/brewers")
     */
    public function getBrewers()
    {
        $brewers = $this->brewerService->getAllBrewers();

        //TODO edit this code/ Here is serialized in wrong way
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $serializer = new Serializer(array($normalizer), array($encoder));
        $json = $serializer->serialize($brewers, 'json');

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
        return View::create($json, Response::HTTP_CREATED);
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

        //TODO edit this code/ Here is serialized in wrong way
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $serializer = new Serializer(array($normalizer), array($encoder));
        $json = $serializer->serialize($beers, 'json');

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
        return View::create($json, Response::HTTP_CREATED);

        //$serializer = SerializerBuilder::create()->build();
        //$jsonObject = $serializer->serialize($beers, 'json');

    }
}
