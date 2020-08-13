<?php

namespace TIC\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use TIC\PlatformBundle\Entity\Trainings;
use TIC\PlatformBundle\Form\TrainingsType;
use Tools\CustomBundle\Controller\MasterController;

class TrainingController extends MasterController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $trainings = $this->em->getRepository("TICPlatformBundle:Trainings")->findAllWithAll();

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->translator->trans('training.list'));

        return $this->render('TICPlatformBundle:Trainings:view.html.twig', array(
            'trainings'=>$trainings
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $training = new Trainings();

        $form = $this->createForm(new TrainingsType(), $training);
        $form = $form->handleRequest($request);

        if( $form->isValid()){
            $this->em->persist($training);
            $this->em->flush();

            return $this->redirect( $this->generateUrl('tic_platform_trainings') );
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('training.list'), 'tic_platform_trainings');
        $breadcrumbs->addItem($this->translator->trans('training.new'));
        
        return $this->render('TICPlatformBundle:Trainings:add.html.twig', array(
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
        $training = $this->em->getRepository('TICPlatformBundle:Trainings')->find($id);

        $this->exceptionIfNull($training);

        $form = $this->createForm(new TrainingsType(), $training);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->flush();
            return $this->redirect($this->generateUrl('tic_platform_trainings'));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('training.list'), 'tic_platform_trainings');
        $breadcrumbs->addItem($this->translator->trans('training.details'));

        return $this->render('TICPlatformBundle:Trainings:edit.html.twig', array(
            'form' => $form->createView(),
            'id'=>$id,
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $training = $this->em->getRepository('TICPlatformBundle:Trainings')->findForDelete($id);

        $this->exceptionIfNull($training);

        if ($training->isDeletable()) {
            $this->em->remove($training);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('tic_platform_trainings'));
    }
}
