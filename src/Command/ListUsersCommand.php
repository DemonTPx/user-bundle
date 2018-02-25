<?php

namespace Demontpx\UserBundle\Command;

use Demontpx\UserBundle\Model\UserInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class ListUsersCommand extends AbstractUserCommand
{
    protected function configure()
    {
        $this->setName('user:list')
            ->setDescription('List users')
            ->addOption('enabled', null, InputOption::VALUE_NONE, 'Show only enabled users');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $enabledOnly = $input->getOption('enabled');
        $userList = $this->userManager->findUserList();

        if ($enabledOnly) {
            $userList = array_filter($userList, function (UserInterface $user) {
                return $user->isEnabled();
            });
        }

        usort($userList, function (UserInterface $left, UserInterface $right) {
            return $left->getUsername() <=> $right->getUsername();
        });

        $table = new Table($output);

        $alignRight = new TableStyle();
        $alignRight->setPadType(STR_PAD_LEFT);

        $alignCenter = new TableStyle();
        $alignCenter->setPadType(STR_PAD_BOTH);

        $table->setHeaders(['id', 'username', 'email', 'full name', 'roles', 'enabled']);
        $table->setColumnStyle(0, $alignRight);
        $table->setColumnStyle(5, $alignCenter);

        foreach ($userList as $user) {
            if ($enabledOnly && ! $user->isEnabled()) {
                continue;
            }

            $table->addRow([
                $user->getId(),
                $user->getUsername(),
                $user->getEmail(),
                $user->getFullName(),
                implode(', ', $user->getRoleList()),
                $user->isEnabled() ? 'yes' : 'no',
            ]);
        }

        $table->render();
    }
}
