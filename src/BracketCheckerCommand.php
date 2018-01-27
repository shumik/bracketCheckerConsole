<?php

namespace BracketCheckerCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use BracketChecker\BracketChecker;

class BracketCheckerCommand extends Command
{

    protected function configure()
    {
        $this->setName("check")
            ->setDescription("Get string from given file and check brackets in there")
            ->addArgument('file', InputArgument::REQUIRED, 'Path to file where your check is stored)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');

        if (!file_exists($file)) {
            $output->writeln(sprintf('File does not exists'));

            return true;
        }

        if (!is_readable($file)) {
            $output->writeln('File is not readable');

            return true;
        }

        $stringToCheck = file_get_contents($file);

        $checker = new BracketChecker();
        $checker->setString($stringToCheck);

        try {
            $output->writeln($checker->check() ? 'Brackets are correct' : 'Brackets are not correct');
        } catch (\InvalidArgumentException $e) {
            $output->writeln('Invalid string format');
        }



    }

}