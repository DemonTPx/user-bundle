<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Events;

use Demontpx\UserBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @copyright 2018 Bert Hekman
 */
class UserEvent extends Event
{
    /** @var UserInterface */
    private $user;
    /** @var int */
    private $id;
    /** @var string */
    private $username;

    public function __construct(UserInterface $user, int $id, string $username)
    {
        $this->user = $user;
        $this->id = $id;
        $this->username = $username;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
