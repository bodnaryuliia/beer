<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Beers;
use App\Entity\Brewers;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $dataBeers = array();

        $repository = $this->getDoctrine()->getRepository(Beers::class);
        $products = $repository->findAll();

        if (is_array($products) && !empty($products)) {
            foreach ($products as $product) {
                $dataBeers[] = array(
                    "brewer" => $product->getBrewerId(),
                    "name" => $product->getName(),
                    "price" => $product->getPrice(),
                    "country" => $product->getCountryId(),
                    "type" => $product->getType(),
                );
            }
        }

        return $this->render(
            'index.html.twig',
            array(
                'dataBeers' => json_encode($dataBeers),
            )
        );
    }
}
