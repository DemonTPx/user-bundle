<?php

namespace Demontpx\UserBundle\Controller;

use Demontpx\UtilBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

/**
 * @copyright 2014 Bert Hekman
 */
class SecurityController extends BaseController
{
    public function loginAction(Request $request)
    {
        return $this->render('@DemontpxUser/security/login.html.twig', [
            'last_username' => $this->getLastUsername($request),
            'error' => $this->getLatestError($request),
            'csrf_token' => $this->getCsrfToken(),
        ]);
    }

    private function getLastUsername(Request $request)
    {
        $session = $request->getSession();

        return ($session === null) ? '' : $session->get(Security::LAST_USERNAME);
    }

    private function getLatestError(Request $request): ?AuthenticationException
    {
        $session = $request->getSession();
        $key = Security::AUTHENTICATION_ERROR;

        $error = null;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($key)) {
            $error = $request->attributes->get($key);
        } elseif ($session !== null && $session->has($key)) {
            $error = $session->get($key);
            $session->remove($key);
        }

        if ( ! $error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        return $error;
    }

    private function getCsrfToken(): ?string
    {
        if ( ! $this->has('security.csrf.token_manager')) {
            return null;
        }

        return $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
    }

    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
