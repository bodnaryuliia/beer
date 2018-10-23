<?php
/**
 * Created by PhpStorm.
 * User: Julia
 * Date: 20.10.2018
 * Time: 17:08
 */
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Service\CallApi;
use App\Service\ParseCallApiResult;

class ReadListOfBeersCommand extends Command
{
    private $callerApi;
    private $parseResult;

    public function __construct(CallApi $callerApi, ParseCallApiResult $parseResult)
    {
        $this->callerApi = $callerApi;
        $this->parseResult = $parseResult;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('read-list-of-beers')
            ->setDescription('Reads a list of beers from a remote API')
            ->setHelp('Reads a list of beers from a remote API http://ontariobeerapi.ca/beers/')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //TODO make ability to chose url
        $result = $this->callerApi->getDataFromApi('http://ontariobeerapi.ca/beers/');
        $this->parseResult->parse($result);

        //TODO remove this string
        $output->writeln($result);
    }

}