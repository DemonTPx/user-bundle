<?php

namespace Demontpx\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseSecurityController;

/**
 * Class SecurityController
 *
 * @package   Demontpx\UserBundle\Controller
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class SecurityController extends BaseSecurityController
{
    /**
     * {@inheritDoc}
     */
    protected function renderLogin(array $data)
    {
        return $this->render('DemontpxUserBundle:Security:login.html.twig', $data);
    }
}
