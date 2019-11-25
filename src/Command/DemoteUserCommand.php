<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class DemoteUserCommand extends AbstractUserCommand
{
    protected function configure()
    {
        $this->setName('user:demote')
            ->setDescription('Demote user by removing a role')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('role', InputArgument::REQUIRED, 'Role');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $role = $input->getArgument('role');

        $user = $this->userManager->findUserByUsername($username);
        $user->removeRole($role);

        $this->userManager->updateUser($user);

        $output->writeln(sprintf('Role "%s" has been removed to user "%s"', $role, $username));

        return 0;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->prompt($input, $output, 'username', 'Choose a username: ');
        $this->prompt($input, $output, 'role', 'Choose a role: ');
    }
}
