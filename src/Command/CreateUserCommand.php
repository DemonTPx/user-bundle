<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class CreateUserCommand extends AbstractUserCommand
{
    protected function configure()
    {
        $this->setName('user:create')
            ->setDescription('Create user')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('email', InputArgument::REQUIRED, 'Email')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
            ->addOption('super-admin', null, InputOption::VALUE_NONE, 'Give user the ROLE_SUPER_ADMIN role')
            ->addOption('disabled', null, InputOption::VALUE_NONE, 'Disable the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userManager->createUser();

        $user->setUsername($input->getArgument('username'));
        $user->setEmail($input->getArgument('email'));
        $user->setPlainPassword($input->getArgument('password'));
        if ($input->getOption('super-admin')) {
            $user->addRole('ROLE_SUPER_ADMIN');
        }
        if ($input->getOption('disabled')) {
            $user->setEnabled(false);
        }

        $this->userManager->updateUser($user);

        $output->writeln(sprintf('User "%s" created', $user->getUsername()));

        return 0;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->prompt($input, $output, 'username', 'Choose a username: ');
        $this->prompt($input, $output, 'email', 'Choose an email address: ');
        $this->prompt($input, $output, 'password', 'Choose a password: ', true);
    }
}
