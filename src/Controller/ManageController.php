<?php

namespace Demontpx\UserBundle\Controller;

use Demontpx\UserBundle\Entity\User;
use Demontpx\UserBundle\Form\UserType;
use Demontpx\UtilBundle\Controller\BaseController;
use Demontpx\UtilBundle\Form\DeleteType;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ManageController
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class ManageController extends BaseController
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('DemontpxUserBundle:User');

        return $this->render('DemontpxUserBundle:Manage:index.html.twig', array(
            'userList'=> $repository->findAll(),
        ));
    }

    /**
     * @param string $username
     *
     * @throws NotFoundHttpException
     * @return Response
     */
    public function showAction($username)
    {
        $user = $this->findUserByUsername($username);

        return $this->render('DemontpxUserBundle:Manage:show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
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

        $form = $this->createForm(UserType::class, $user);
        $this->addReferrerToForm($form);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getUserManager();
            $manager->updateUser($user);

            return $this->redirectToFormReferrer($form, $this->generateUrl('demontpx_user_manage_index'));
        }

        return $this->render('DemontpxUserBundle:Manage:edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
            'new' => false,
        ));
    }

    /**
     * @param Request $request
     * @param string  $username
     *
     * @return RedirectResponse|Response
     */
    public function deleteAction(Request $request, $username = null)
    {
        $user = $this->findUserByUsername($username);

        $form = $this->createForm(DeleteType::class, $user);
        $this->addReferrerToForm($form);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager = $this->getUserManager();
            $manager->deleteUser($user);

            return $this->redirectToFormReferrer($form, $this->generateUrl('demontpx_user_manage_index'));
        }

        return $this->render('DemontpxUserBundle:Manage:delete.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
        ));
    }

    /**
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
