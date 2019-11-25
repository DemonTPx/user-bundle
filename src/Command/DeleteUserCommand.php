<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class DeleteUserCommand extends AbstractUserCommand
{
    protected function configure()
    {
        $this->setName('user:delete')
            ->setDescription('Create user')
            ->addArgument('username', InputArgument::REQUIRED, 'Username');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');

        $user = $this->userManager->findUserByUsername($username);

        $this->userManager->deleteUser($user);

        $output->writeln(sprintf('User "%s" deleted', $username));

        return 0;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->prompt($input, $output, 'username', 'Choose a username: ');
    }
}
