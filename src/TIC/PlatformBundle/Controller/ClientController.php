<?php

namespace TIC\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TIC\PlatformBundle\Entity\ClientAddresses;
use TIC\PlatformBundle\Entity\Clients;
use TIC\PlatformBundle\Entity\ContactPeople;
use TIC\PlatformBundle\Form\ClientAddressesType;
use TIC\PlatformBundle\Form\ClientsSearchType;
use TIC\PlatformBundle\Form\ClientsType;
use TIC\PlatformBundle\Form\ContactPeopleType;
use Tools\CustomBundle\Controller\MasterController;

class ClientController extends MasterController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $clients = $this->em->getRepository("TICPlatformBundle:Clients")->findAllWithAll();

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->translator->trans('client.list'));

        return $this->render('TICPlatformBundle:Clients:view.html.twig', array(
            'clients' => $clients
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $client = new Clients();
        $form = $this->createForm(new ClientsType(false), $client);

        $form = $form->handleRequest($request);

        if ($form->isValid()) {

            $this->em->persist($client);
            $this->em->flush();

            return $this->redirect($this->generateUrl('tic_platform_clients_edit',
                array('id' => $client->getId())));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('client.list'), 'tic_platform_clients');
        $breadcrumbs->addItem($this->translator->trans('client.new'));

        return $this->render('TICPlatformBundle:Clients:add.html.twig', array(
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
        $client = $this->em->getRepository('TICPlatformBundle:Clients')->findOneWithAll($id);

        $this->exceptionIfNull($client);

        $form = $this->createForm(new ClientsType(false), $client);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->em->flush();
            return $this->redirect($this->generateUrl('tic_platform_clients'));
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans('client.list'), 'tic_platform_clients');
        $breadcrumbs->addItem($this->translator->trans('client.edit'));

        return $this->render('TICPlatformBundle:Clients:edit.html.twig', array(
            'form' => $form->createView(),
            'client' => $client,
            'CLIENTID' => $id
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $client = $this->em->getRepository('TICPlatformBundle:Clients')->findForDelete($id);

        $this->exceptionIfNull($client);

        if ($client->isDeletable()) {
            $this->em->remove($client);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('tic_platform_clients'));
    }

    /**
     * @param $id
     * @param $idAddress
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addressAction($id, $idAddress, Request $request)
    {
        $client = $this->em->getRepository('TICPlatformBundle:Clients')->find($id);

        $this->exceptionIfNull($client);

        $clientAddress = $this->em->getRepository('TICPlatformBundle:ClientAddresses')->findOneWithAll($client, $idAddress);

        if (null === $clientAddress) {
            $clientAddress = new ClientAddresses();
        }

        $form = $this->createForm(new ClientAddressesType(), $clientAddress);
        $form = $form->handleRequest($request);

        if ($form->isValid() && $this->get('validator')->validate($clientAddress)) {
            $client->addClientAddress($clientAddress);
            $this->em->persist($client);
            $this->em->flush();

            return new JsonResponse(array("status" => "Success", "code" => 200));
        }

        return $this->render('TICPlatformBundle:ClientsAddresses:form2.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $id
     * @param $idAddress
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAddressAction($id, $idAddress)
    {
        $clientAddress = $this->em->getRepository('TICPlatformBundle:ClientAddresses')->findForDelete($id, $idAddress);

        $this->exceptionIfNull($clientAddress);

        if ($clientAddress->isDeletable()) {
            $this->em->remove($clientAddress);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('tic_platform_clients_edit', array(
            'id' => $id,
        )));
    }

    /**
     * @param $id
     * @param $idContact
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contactAction($id, $idContact, Request $request)
    {
        $client = $this->em->getRepository('TICPlatformBundle:Clients')->find($id);

        $this->exceptionIfNull($client);

        $clientContact = $this->em->getRepository('TICPlatformBundle:ContactPeople')->findOneWithAll($client, $idContact);

        if (null === $clientContact) {
            $clientContact = new ContactPeople();
        }

        $form = $this->createForm(new ContactPeopleType(), $clientContact);
        $form = $form->handleRequest($request);

        if ($form->isValid() && $this->get('validator')->validate($clientContact)) {
            $client->addContactPerson($clientContact);
            $this->em->persist($client);
            $this->em->flush();
            return new JsonResponse(array("status" => "Success", "code" => 200));
        }

        return $this->render('TICPlatformBundle:ContactPeople:form2.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $id
     * @param $idContact
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteContactAction($id, $idContact)
    {
        $clientContact = $this->em->getRepository('TICPlatformBundle:ContactPeople')->findForDelete($id, $idContact);

        $this->exceptionIfNull($clientContact);

        if ($clientContact->isDeletable()) {
            $this->em->remove($clientContact);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('tic_platform_clients_edit', array(
            'id' => $id,
        )));
    }

}
