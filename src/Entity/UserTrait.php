<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
