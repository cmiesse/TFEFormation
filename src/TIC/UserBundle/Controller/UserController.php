<?php

namespace TIC\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use TIC\UserBundle\Entity\User;
use TIC\UserBundle\Form\UserType;
use Tools\CustomBundle\Controller\MasterController;

class UserController extends MasterController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $users = $this->em->getRepository("TICUserBundle:User")->findAllWithoutSuperAdmin();
        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->translator->trans('user.list'));
        
        return $this->render('TICUserBundle:Users:view.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $form = $this->createForm(new UserType(), $user);

        $form = $form->handleRequest($request);

        if ($form->isValid()) {

            $user->setEnabled(true);
            $this->get('fos_user.user_manager')->updateUser($user, false);
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirect($this->generateUrl('tic_platform_users'));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('user.list'), 'tic_platform_users');
        $breadcrumbs->addItem($this->translator->trans('user.new'));
        
        return $this->render('TICUserBundle:Users:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {
        $user = $this->em->getRepository('TICUserBundle:User')->find($id);

        $this->exceptionIfNull($user);

        if ($user->isSuperAdmin()) {
            throw new BadRequestHttpException();
        }

        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('fos_user.user_manager')->updateUser($user, false);
            $this->em->flush();

            return $this->redirect($this->generateUrl('tic_platform_users'));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('user.list'), 'tic_platform_users');
        $breadcrumbs->addItem($this->translator->trans('users.edit'));

        return $this->render('TICUserBundle:Users:edit.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $user = $this->em->getRepository('TICUserBundle:User')->find($id);

        $this->exceptionIfNull($user);

        if($this->getUser() !== $user && !$user->isSuperAdmin())
        {
            $this->em->remove($user);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('tic_platform_users'));
    }
}

