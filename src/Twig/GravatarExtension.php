<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Twig;

use Demontpx\UserBundle\Entity\User;
use Demontpx\UserBundle\Service\Gravatar;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @copyright 2017 Bert Hekman
 */
class GravatarExtension extends AbstractExtension
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
            new TwigFunction('gravatar', [$this->gravatar, 'getUrl'], ['is_safe' => ['html']]),
            new TwigFunction('user_gravatar', [$this, 'getUserGravatarUrl'], ['is_safe' => ['html']]),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('gravatar', [$this->gravatar, 'getUrl'], ['is_safe' => ['html']]),
            new TwigFilter('user_gravatar', [$this, 'getUserGravatarUrl'], ['is_safe' => ['html']]),
        ];
    }

    public function getUserGravatarUrl(User $user, $size = null, $rating = null, $default = null, $forceDefault = null)
    {
        return $this->gravatar->getUrl($user->getEmail(), $size, $rating, $default, $forceDefault);
    }
}
