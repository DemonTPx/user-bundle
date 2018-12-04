<?php

namespace Demontpx\UserBundle\Model;

/**
 * @copyright 2018 Bert Hekman
 */
abstract class AbstractUser implements UserInterface, \Serializable
{
    /** @var ?mixed */
    protected $id;
    /** @var string */
    protected $username = '';
    /** @var ?string */
    protected $fullName;
    /** @var string */
    protected $email = '';
    /** @var bool */
    protected $enabled = true;
    /** @var ?string */
    protected $salt;
    /** @var string */
    protected $password;
    /** @var ?string */
    protected $plainPassword;
    /** @var ?\DateTimeInterface */
    protected $lastLogin;
    /** @var string[] */
    protected $roleList = [];

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->fullName,
            $this->email,
            $this->enabled,
            $this->salt,
            $this->password,
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        list(
            $this->id,
            $this->username,
            $this->fullName,
            $this->email,
            $this->enabled,
            $this->salt,
            $this->password
        ) = $data;
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username ?? '';
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getFullName(): string
    {
        return $this->fullName ?? $this->username ?? '';
    }

    public function setFullName(?string $fullName)
    {
        $this->fullName = $fullName;
    }

    public function getEmail(): string
    {
        return $this->email ?? '';
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }

    public function getSalt(): ?string
    {
        return $this->salt ?? '';
    }

    public function setSalt(?string $salt)
    {
        $this->salt = $salt;
    }

    public function getPassword(): string
    {
        return $this->password ?? '';
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $password)
    {
        $this->plainPassword = $password;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    public function getRoles()
    {
        return $this->getRoleList();
    }

    public function getRoleList(): array
    {
        if ( ! in_array(static::ROLE_DEFAULT, $this->roleList, true)) {
            $this->roleList[] = static::ROLE_DEFAULT;
        }

        return $this->roleList;
    }

    public function setRoleList(array $roleList)
    {
        $this->roleList = $roleList;
    }

    public function addRole(string $role)
    {
        if ( ! in_array($role, $this->roleList)) {
            $this->roleList[] = $role;
        }
    }

    public function removeRole(string $role)
    {
        $position = array_search($role, $this->roleList, true);
        if ($position !== false) {
            unset($this->roleList[$position]);
        }
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }
}
