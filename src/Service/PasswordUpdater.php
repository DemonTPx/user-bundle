<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Service;

use Demontpx\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\SelfSaltingEncoderInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class PasswordUpdater implements PasswordUpdaterInterface
{
    private EncoderFactoryInterface $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function hashPassword(UserInterface $user): void
    {
        $plainPassword = $user->getPlainPassword();

        if (null === $plainPassword || 0 === strlen($plainPassword)) {
            return;
        }

        $encoder = $this->encoderFactory->getEncoder($user);

        if ($encoder instanceof BCryptPasswordEncoder || $encoder instanceof SelfSaltingEncoderInterface) {
            $user->setSalt(null);
        } else {
            $salt = rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '=');
            $user->setSalt($salt);
        }

        $hashedPassword = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($hashedPassword);
        $user->eraseCredentials();
    }
}
