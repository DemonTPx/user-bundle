<?php

namespace Demontpx\UserBundle\Model;

use Symfony\Component\Security\Core\User\AdvancedUserInterface as BaseUserInterface;

/**
 * @copyright 2018 Bert Hekman
 */
interface UserInterface extends BaseUserInterface
{
    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    public function getId();
    public function setId($id);
    public function setUsername(string $username);
    public function getFullName(): string;
    public function setFullName(string $fullName);
    public function getEmail(): string;
    public function setEmail(string $email);
    public function isEnabled(): bool;
    public function setEnabled(bool $enabled);
    public function setSalt(?string $salt);
    public function setPassword(string $password);
    public function getPlainPassword(): ?string;
    public function setPlainPassword(?string $password);
    public function getLastLogin(): ?\DateTimeInterface;
    public function setLastLogin(?\DateTimeInterface $dateTime);

    /**
     * @return string[]
     */
    public function getRoleList(): array;

    /**
     * @param string[] $roleList
     */
    public function setRoleList(array $roleList);
}
