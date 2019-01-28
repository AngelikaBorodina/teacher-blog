<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MyFirstCommand extends Command
{
    protected function configure()
    {
        $this->setName('ang:test');
        $this->addArgument('name',InputArgument::OPTIONAL);
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $name=$input->getArgument('name');
        $output->writeln('Hello, '.(isset($name)?$name:'friend!'));
    }

}