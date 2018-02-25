<?php

namespace Demontpx\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class PromoteUserCommand extends AbstractUserCommand
{
    protected function configure()
    {
        $this->setName('user:promote')
            ->setDescription('Promote user by adding a role')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('role', InputArgument::REQUIRED, 'Role');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $role = $input->getArgument('role');

        $user = $this->userManager->findUserByUsername($username);
        $user->addRole($role);

        $this->userManager->updateUser($user);

        $output->writeln(sprintf('Role "%s" has been added to user "%s"', $role, $username));
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->prompt($input, $output, 'username', 'Choose a username: ');
        $this->prompt($input, $output, 'role', 'Choose a role: ');
    }
}
