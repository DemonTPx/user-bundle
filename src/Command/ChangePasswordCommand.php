<?php

namespace Demontpx\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class ChangePasswordCommand extends AbstractUserCommand
{
    protected function configure()
    {
        $this->setName('user:change-password')
            ->setDescription('Change user password')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('password', InputArgument::REQUIRED, 'Password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        $user = $this->userManager->findUserByUsername($username);
        $user->setPlainPassword($password);

        $this->userManager->updateUser($user);

        $output->writeln(sprintf('Password changed for user "%s"', $username));
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->prompt($input, $output, 'username', 'Choose a username: ');
        $this->prompt($input, $output, 'password', 'Choose a password: ', true);
    }
}
