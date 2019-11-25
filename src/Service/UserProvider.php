<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Service;

use Demontpx\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class UserProvider implements UserProviderInterface
{
    /** @var UserManagerInterface */
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if ( ! $user) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $user;
    }

    public function refreshUser(SecurityUserInterface $user)
    {
        if ( ! $user instanceof UserInterface || ! $this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Expected an instance of %s, but got "%s".', UserInterface::class, get_class($user)));
        }

        $reloadedUser = $this->userManager->findUserBy(['id' => $user->getId()]);

        if ( ! $reloadedUser) {
            throw new UsernameNotFoundException(sprintf('User with ID "%s" could not be reloaded.', $user->getId()));
        }

        return $reloadedUser;
    }

    public function supportsClass($class)
    {
        return $class === UserInterface::class || is_subclass_of($class, UserInterface::class, true);
    }
}
