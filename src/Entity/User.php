<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Entity;

use Demontpx\UserBundle\Model\AbstractUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @copyright 2014 Bert Hekman
 *
 * @ORM\Entity(repositoryClass="Demontpx\UserBundle\Repository\UserRepository")
 * @ORM\Table
 */
class User extends AbstractUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $username = '';

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fullName;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $email = '';

    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled = true;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $salt;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    protected $roleList = [];
}
