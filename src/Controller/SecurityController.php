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
        $template = sprintf('DemontpxUserBundle:Security:login.html.%s',
            $this->container->getParameter('fos_user.template.engine')
        );

        return $this->container->get('templating')->renderResponse($template, $data);
    }
}
