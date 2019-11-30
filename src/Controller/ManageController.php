<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Controller;

use Demontpx\UserBundle\Entity\User;
use Demontpx\UserBundle\Form\UserType;
use Demontpx\UserBundle\Repository\UserRepository;
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
    private UserRepository $repository;
    private UserManagerInterface $manager;

    public function __construct(UserRepository $repository, UserManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    public function indexAction(): Response
    {
        return $this->render('@DemontpxUser/manage/index.html.twig', [
            'userList' => $this->repository->findAll(),
        ]);
    }

    public function showAction(User $user): Response
    {
        return $this->render('@DemontpxUser/manage/show.html.twig', [
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
            $this->manager->updateUser($user);

            return $this->redirectToFormReferrer($form, $this->generateUrl('demontpx_user_manage_index'));
        }

        return $this->render('@DemontpxUser/manage/edit.html.twig', [
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
            $this->manager->deleteUser($user);

            return $this->redirectToFormReferrer($form, $this->generateUrl('demontpx_user_manage_index'));
        }

        return $this->render('@DemontpxUser/manage/delete.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
