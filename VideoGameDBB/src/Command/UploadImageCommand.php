<?php

namespace App\Command;

use App\Entity\Videogame;
use App\Repository\VideogameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UploadImageCommand extends Command
{
    protected static $defaultName = 'app:upload-image';

    private $em;
    private $videogameRepository;

    public function __construct(EntityManagerInterface $em, VideogameRepository $videogameRepository)
    {
        parent::__construct();

        $this->em = $em;
        $this->videogameRepository = $videogameRepository;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Chargement des images')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', '-m', InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $videogames = $this->videogameRepository->findAll();
        foreach($videogames as $videogame){
            $videogame->setImageFilename('bbbbbbbbbbbbbbbbbbbbbbb');
        }
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
