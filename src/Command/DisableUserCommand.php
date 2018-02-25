<?php

namespace Demontpx\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class DisableUserCommand extends AbstractUserCommand
{
    protected function configure()
    {
        $this->setName('user:disable')
            ->setDescription('Disable user')
            ->addArgument('username', InputArgument::REQUIRED, 'Username');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');

        $user = $this->userManager->findUserByUsername($username);
        $user->setEnabled(false);

        $this->userManager->updateUser($user);

        $output->writeln(sprintf('User "%s" has been disabled', $username));
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->prompt($input, $output, 'username', 'Choose a username: ');
    }
}
