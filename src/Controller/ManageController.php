<?php

namespace Demontpx\UserBundle\Controller;

use Demontpx\UserBundle\Entity\User;
use Demontpx\UserBundle\Form\UserType;
use Demontpx\UserBundle\Service\UserManagerInterface;
use Demontpx\UtilBundle\Controller\BaseController;
use Demontpx\UtilBundle\Form\DeleteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @copyright 2014 Bert Hekman
 */
class ManageController extends BaseController
{
    public function indexAction(): Response
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('DemontpxUserBundle:User');

        return $this->render('DemontpxUserBundle:manage:index.html.twig', [
            'userList' => $repository->findAll(),
        ]);
    }

    public function showAction(User $user): Response
    {
        return $this->render('DemontpxUserBundle:manage:show.html.twig', [
            'user' => $user,
        ]);
    }

    public function addAction(Request $request): Response
    {
        return $this->editAction($request, new User());
    }

    public function editAction(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $this->addReferrerToForm($form);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getUserManager();
            $manager->updateUser($user);

            return $this->redirectToFormReferrer($form, $this->generateUrl('demontpx_user_manage_index'));
        }

        return $this->render('DemontpxUserBundle:manage:edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'new' => ($user->getId() === null),
        ]);
    }

    public function deleteAction(Request $request, User $user): Response
    {
        $form = $this->createForm(DeleteType::class, $user);
        $this->addReferrerToForm($form);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getUserManager();
            $manager->deleteUser($user);

            return $this->redirectToFormReferrer($form, $this->generateUrl('demontpx_user_manage_index'));
        }

        return $this->render('DemontpxUserBundle:manage:delete.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    private function getUserManager(): UserManagerInterface
    {
        return $this->get('demontpx_user.user_manager');
    }
}
