<?php

namespace Demontpx\UserBundle\Form;

use Symfony\Component\Form\AbstractType;

/**
 * Class UserDeleteType
 *
 * @package   Demontpx\UserBundle\Form
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class UserDeleteType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'user_delete';
    }
}
