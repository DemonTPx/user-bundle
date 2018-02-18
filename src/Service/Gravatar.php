<?php

namespace Demontpx\UserBundle\Service;

/**
 * @copyright 2017 Bert Hekman
 */
class Gravatar
{
    const RATING_GENERAL = 'g';
    const RATING_PARENTAL_GUIDANCE = 'pg';
    const RATING_RESTRICTED = 'r';
    const RATING_PORNOGRAPHY = 'x';

    const DEFAULT_404 = '404';
    const DEFAULT_MYSTERY_MAN = 'mm';
    const DEFAULT_IDENTICON = 'identicon';
    const DEFAULT_MONSTER_ID = 'monsterid';
    const DEFAULT_WAVATAR = 'wavatar';
    const DEFAULT_RETRO = 'retro';
    const DEFAULT_BLANK = 'blank';

    /** @var int */
    private $defaultSize;

    /** @var string */
    private $defaultRating;

    /** @var string */
    private $defaultDefault;

    /** @var bool */
    private $defaultForceDefault;

    public function __construct(
        int $defaultSize = 80,
        string $defaultRating = self::RATING_GENERAL,
        string $defaultDefault = self::DEFAULT_MYSTERY_MAN,
        bool $defaultForceDefault = false
    )
    {
        $this->defaultSize = $defaultSize;
        $this->defaultRating = $defaultRating;
        $this->defaultDefault = $defaultDefault;
        $this->defaultForceDefault = $defaultForceDefault;
    }

    public function getUrl(
        string $email,
        int $size = null,
        string $rating = null,
        string $default = null,
        bool $forceDefault = null
    ): string
    {
        $hash = md5(strtolower(trim($email)));

        $map = [
            's' => $size ?? $this->defaultSize,
            'r' => $rating ?? $this->defaultRating,
            'd' => $default ?? $this->defaultDefault,
            'f' => ($forceDefault ?? $this->defaultForceDefault) ? 'y' : null,
        ];

        return '//www.gravatar.com/avatar/' . $hash . '?' . http_build_query(array_filter($map));
    }
}
