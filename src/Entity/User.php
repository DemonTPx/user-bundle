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
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id = null;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected string $username = '';

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $fullName = null;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected string $email = '';

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $enabled = true;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $salt = null;

    /**
     * @ORM\Column(type="string")
     */
    protected string $password = '';

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected ?\DateTimeInterface $lastLogin = null;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    protected array $roleList = [];
}
