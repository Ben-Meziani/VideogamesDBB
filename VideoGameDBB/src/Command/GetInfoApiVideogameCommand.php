<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Videogame;
use App\Repository\VideogameRepository;
use App\Service\ApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetInfoApiVideogameCommand extends Command
{
    protected static $defaultName = 'app:get-infoApi-videogame';
    protected static $defaultDescription = 'Add a short description for your command';

    private $em;
    private $videogameRepository;

    public function __construct(EntityManagerInterface $em, VideogameRepository $videogameRepository, ApiService $apiservice)
    {
        parent::__construct();

        $this->em = $em;
        $this->videogameRepository = $videogameRepository;
        $this->apiservice = $apiservice;
    }



    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $categoryArray = ['FPS', 'Action', 'Aventure', 'Stratégie', 'Jeux de société'];
        $categoryList = [];
        $videogameList = [];
        for ($i = 0; $i < count($categoryArray); $i++) {
            $category = new Category;
            $category->setLabel($categoryArray[$i]);
            $this->em->persist($category);
            $categoryList[] = $category;
        }

        $endEndpoint = 'games';
        $apiInfo = $this->apiservice->curlApi($endEndpoint);
        $endEndpointCover = 'covers';
        $apiInfoImage = $this->apiservice->curlApi($endEndpointCover);
            for ($j = 0; $j <= count($apiInfo)-1; $j++) {
                $videogame = new Videogame;
                $videogame
                    ->setName($apiInfo[$j]['name'])
                    ->setReleaseDate(new \DateTime("2020-01-01 03:02:26"))
                    ->setImageFilename($apiInfoImage[$j]['url'])
                    ->setSummary($apiInfo[$j]['summary']);
                //Cette boucle sert à ajouter entre une et 5 catégories à un jeux
                for ($k = 0; $k <= mt_rand(1, 2); $k++) {
                    //L'index du tableau commençant a 0, on retire 1 pour être sur de récupérer une valeur existante dans le tableau
                    $categoryRandom = $categoryList[mt_rand(0, count($categoryList) - 1)];
                    //Ici on vérifie qu'un jeu n'est pas lié à une catégorie pour éviter les doublons
                    if (!$videogame->getCategories()->contains($categoryRandom)) {
                        $videogame->addCategory($categoryRandom);
                    }
                }
                $this->em->persist($videogame);
                $videogameList[] = $videogame;
            }
        
        // Pour chaque film, on fait une requête sur OMDbAPI avec le titre
        // On récupère le poster, on le télécharge et on attribut le nom de ce fichier à notre $videogame                       

        $this->em->flush();

        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
