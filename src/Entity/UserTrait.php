<?php

namespace Demontpx\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserTrait
 *
 * @package   Demontpx\UserBundle\Entity
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
trait UserTrait
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Demontpx\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
