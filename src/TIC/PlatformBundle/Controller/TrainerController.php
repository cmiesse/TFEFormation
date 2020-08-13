<?php

namespace TIC\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use TIC\PlatformBundle\Entity\Trainers;
use TIC\PlatformBundle\Form\TrainersType;
use Tools\CustomBundle\Controller\MasterController;

class TrainerController extends MasterController
{
    public function indexAction()
    {
        $trainers = $this->em->getRepository("TICPlatformBundle:Trainers")->findAll();

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->translator->trans('trainer.list'));

        return $this->render('TICPlatformBundle:Trainers:view.html.twig', array(
            'trainers' => $trainers
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $trainer = new Trainers();

        $form = $this->createForm(new TrainersType(), $trainer);
        $form = $form->handleRequest($request);

        if ($form->isValid()) {
            $trainer->updateFiles($this->getParameter('upload_dir'), $this->em);
            $this->em->persist($trainer);
            $this->em->flush();

            return $this->redirect($this->generateUrl('tic_platform_trainers'));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('trainer.list'), 'tic_platform_trainers');
        $breadcrumbs->addItem($this->translator->trans('trainer.new'));

        return $this->render('TICPlatformBundle:Trainers:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $trainer = $this->em->getRepository('TICPlatformBundle:Trainers')->findOneWithAll($id);
        $this->exceptionIfNull($trainer);

        $form = $this->createForm(new TrainersType(), $trainer);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $trainer->updateFiles($this->getParameter('upload_dir'), $this->em);
            $this->em->flush();
            return $this->redirect($this->generateUrl('tic_platform_trainers'));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('trainer.list'), 'tic_platform_trainers');
        $breadcrumbs->addItem($this->translator->trans('trainer.edit'));

        return $this->render('TICPlatformBundle:Trainers:edit.html.twig', array(
            'form' => $form->createView(),
            'trainer' => $trainer
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $trainer = $this->em->getRepository('TICPlatformBundle:Trainers')->findForDelete($id);

        $this->exceptionIfNull($trainer);

        if ($trainer->isDeletable()) {
            $trainer->prepareForRemoveFiles($this->getParameter('upload_dir'));
            $this->em->remove($trainer);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('tic_platform_trainers'));
    }
}
