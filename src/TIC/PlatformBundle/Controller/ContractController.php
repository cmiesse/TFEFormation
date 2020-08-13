<?php

namespace TIC\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use TIC\PlatformBundle\Entity\Clients;
use TIC\PlatformBundle\Entity\Contracts;
use TIC\PlatformBundle\Form\ContractsType;
use TIC\PlatformBundle\Helpers\CountDays;
use Tools\CustomBundle\Controller\MasterController;

class ContractController extends MasterController
{
    /**
     * @param Clients $client
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Clients $client, $id)
    {
        $this->exceptionIfNull($client);

        $contracts = $this->em->getRepository('TICPlatformBundle:Contracts')->findAllByClient($client);

        foreach ($contracts as $contract) {
            $days = 0;
            foreach ($contract->getSessions() as $session) {
                $days += CountDays::calculDays($session->getEvents());
            }
            $contract->setContractBalance($contract->getContractTotalAmount() - $days * $contract->getContractDailyAmount());
        }
        $this->em->flush();
        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('client.list'), 'tic_platform_clients');
        $breadcrumbs->addRouteItem($client->getClientName(), 'tic_platform_clients_edit', array('id' => $client->getId()));
        $breadcrumbs->addItem($this->translator->trans('contract.list'));

        return $this->render('TICPlatformBundle:Contracts:view.html.twig', array(
            'contracts' => $contracts,
            'id' => $id,
        ));
    }

    /**
     * @param Request $request
     * @param Clients $client
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, Clients $client)
    {
        $contract = new Contracts();

        $form = $this->createForm(new ContractsType(), $contract);
        $form->handleRequest($request);

        if( $form->isValid()){
            $contract->setClient($client);
            $this->em->persist($contract);
            $this->em->flush();

            return $this->redirect( $this->generateUrl('tic_platform_contracts', array(
                'id' => $client->getId(),
            )));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('client.list'), 'tic_platform_clients');
        $breadcrumbs->addRouteItem($client->getClientName(), 'tic_platform_clients_edit', array('id' => $client->getId()));
        $breadcrumbs->addRouteItem($this->translator->trans('contract.list'), 'tic_platform_contracts', array('id' => $client->getId()));
        $breadcrumbs->addItem($this->translator->trans('contract.new'));

        return $this->render('TICPlatformBundle:Contracts:add.html.twig', array(
            'form' => $form->createView(),
            'id' => $client->getId(),
        ));
    }

    /**
     * @param $id
     * @param $idContract
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, $idContract, Request $request)
    {
        $contract = $this->em->getRepository('TICPlatformBundle:Contracts')->findOneWithAll($id, $idContract);

        $this->exceptionIfNull($contract);

        $client = $contract->getClient();

        $form = $this->createForm(new ContractsType(), $contract);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->flush();
            return $this->redirect($this->generateUrl('tic_platform_contracts', array(
                'id' => $id,
            )));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('client.list'), 'tic_platform_clients');
        $breadcrumbs->addRouteItem($client->getClientName(), 'tic_platform_clients_edit', array('id' => $client->getId()));
        $breadcrumbs->addRouteItem($this->translator->trans('contract.list'), 'tic_platform_contracts', array('id' => $client->getId()));
        $breadcrumbs->addItem($this->translator->trans('contract.edit'));

        return $this->render('TICPlatformBundle:Contracts:edit.html.twig', array(
            'form' => $form->createView(),
            'id'=>$id,
            'contract' => $contract
        ));
    }

    /**
     * @param $id
     * @param $idContract
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id, $idContract)
    {
        $contract = $this->em->getRepository('TICPlatformBundle:Contracts')->findForDelete($id, $idContract);

        $this->exceptionIfNull($contract);

        if ($contract->isDeletable()) {
            $this->em->remove($contract);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('tic_platform_contracts', array(
            'id' => $id,
        )));
    }
}
