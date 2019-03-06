<?php

namespace Demontpx\UserBundle\Service;

use Demontpx\UserBundle\Model\UserInterface as DemontpxUserInterface;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @copyright 2019 Bert Hekman
 */
class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if ( ! $user instanceof DemontpxUserInterface) {
            return;
        }

        if ( ! $user->isEnabled()) {
            $exception = new DisabledException('User account is disabled.');
            $exception->setUser($user);

            throw $exception;
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
    }
}
