<?php

namespace DemonTPx\UserBundle\Controller;

use DemonTPx\UserBundle\Entity\User;
use DemonTPx\UtilBundle\Controller\BaseController;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserController
 *
 * @package   DemonTPx\UserBundle\Controller
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class UserController extends BaseController
{
    /**
     * List all users
     *
     * @return Response
     */
    public function indexAction()
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('DemonTPxUserBundle:User');

        return $this->render('DemonTPxUserBundle:User:index.html.twig', array(
            'userList'=> $repository->findAll(),
        ));
    }

    /**
     * Show user
     *
     * @param string $username
     *
     * @throws NotFoundHttpException
     * @return Response
     */
    public function showAction($username)
    {
        $user = $this->findUserByUsername($username);

        return $this->render('DemonTPxUserBundle:User:show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * New or edit user
     *
     * @param Request $request
     * @param string  $username
     * @param bool    $new
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $username = null, $new = false)
    {
        if ($new) {
            $user = new User();
        } else {
            $user = $this->findUserByUsername($username);
        }

        $form = $this->createForm('user', $user);
        $this->addReferrerToForm($form);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getUserManager();
            $manager->updateUser($user);

            return $this->redirectToFormReferrer($form, $this->generateUrl('demontpx_user_index'));
        }

        return $this->render('DemonTPxUserBundle:User:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
            'new' => false,
        ));
    }

    /**
     * Find user by username
     *
     * @param string $username
     *
     * @return User
     * @throws NotFoundHttpException
     */
    private function findUserByUsername($username)
    {
        $manager = $this->getUserManager();
        $user = $manager->findUserByUsername($username);

        if ( ! $user) {
            throw $this->createNotFoundException('User not found');
        }

        return $user;
    }

    /**
     * @return UserManager
     */
    private function getUserManager()
    {
        return $this->get('fos_user.user_manager');
    }
}
