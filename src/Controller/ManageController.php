<?php

namespace Demontpx\UserBundle\Controller;

use Demontpx\UserBundle\Entity\User;
use Demontpx\UserBundle\Form\UserType;
use Demontpx\UtilBundle\Controller\BaseController;
use Demontpx\UtilBundle\Form\DeleteType;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ManageController
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class ManageController extends BaseController
{
    public function indexAction(): Response
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('DemontpxUserBundle:User');

        return $this->render('DemontpxUserBundle:Manage:index.html.twig', array(
            'userList' => $repository->findAll(),
        ));
    }

    public function showAction(string $username): Response
    {
        $user = $this->findUserByUsername($username);

        return $this->render('DemontpxUserBundle:Manage:show.html.twig', array(
            'user' => $user,
        ));
    }

    public function editAction(Request $request, string $username = null, bool $new = false): Response
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

    public function deleteAction(Request $request, string $username = null): Response
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

    private function findUserByUsername(string $username): User
    {
        $manager = $this->getUserManager();
        $user = $manager->findUserByUsername($username);

        if ( ! $user) {
            throw $this->createNotFoundException('User not found');
        }

        return $user;
    }

    private function getUserManager(): UserManager
    {
        return $this->get('fos_user.user_manager');
    }
}
