<?php

namespace Demontpx\UserBundle\Twig;

use Demontpx\UserBundle\Entity\User;
use Demontpx\UserBundle\Service\Gravatar;

/**
 * Class GravatarExtension
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2017 Bert Hekman
 */
class GravatarExtension extends \Twig_Extension
{
    /** @var Gravatar */
    private $gravatar;

    public function __construct(Gravatar $gravatar)
    {
        $this->gravatar = $gravatar;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('gravatar', [$this->gravatar, 'getUrl'], ['is_safe' => ['html']]),
            new \Twig_Function('user_gravatar', [$this, 'getUserGravatarUrl'], ['is_safe' => ['html']]),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_Function('gravatar', [$this->gravatar, 'getUrl'], ['is_safe' => ['html']]),
            new \Twig_Function('user_gravatar', [$this, 'getUserGravatarUrl'], ['is_safe' => ['html']]),
        ];
    }

    public function getUserGravatarUrl(User $user, $size = null, $rating = null, $default = null, $forceDefault = null)
    {
        return $this->gravatar->getUrl($user->getEmail(), $size, $rating, $default, $forceDefault);
    }
}
