<?php

namespace Demontpx\UserBundle\Service;

use Demontpx\UserBundle\Model\UserInterface;

/**
 * @copyright 2018 Bert Hekman
 */
interface PasswordUpdaterInterface
{
    public function hashPassword(UserInterface $user): void;
}
