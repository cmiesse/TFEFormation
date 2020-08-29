<?php
namespace TIC\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Tools\CustomBundle\Controller\MasterController;
use Tools\CustomBundle\Interfaces\TemplateInterface;

abstract class ParameterController extends MasterController implements TemplateInterface
{
    /**
     * @var string
     */
    protected $repo;

    /**
     * @var string
     */
    protected $indexTwig;

    /**
     * @var string
     */
    protected $editTwig;

    /**
     * @var string
     */
    protected $indexRoute;

    /**
     * @var string
     */
    protected $screenName;

    protected $emptyObject;

    protected $formType;

    public function __construct()
    {
        $this->setRequiredNames();
        $this->validateNames();
    }

    public function validateNames()
    {
        $names = array(
            "repo", "indexTwig", "editTwig", "indexRoute", "screenName", 'emptyObject', "formType"
        );

        foreach ($names as $i => $name) {
            if (!isset($this->$name)) {
                throw new \InvalidArgumentException(sprintf("Missing argument : %s", $name));
            }
        }
    }

    public abstract function setRequiredNames();

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $items = $this->em->getRepository($this->repo)->findAllWithRequiredData();

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->translator->trans(/** @Ignored */sprintf("%s.list", $this->screenName)));

        return $this->render($this->indexTwig, array(
            'items' => $items
        ));
    }

    /**
     * @param Request $request
     * @param $itemID
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $itemID)
    {
        $item = $this->em->getRepository($this->repo)->findOneWithRequiredData($itemID);
        $isAdd = false;

        if ($item === null) {
            $item = clone $this->emptyObject;
            $isAdd = true;
        }

        $form = $this->createForm($this->formType, $item);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($isAdd) {
                $this->em->persist($item);
            }
            $this->em->flush();
            return $this->redirectToRoute($this->indexRoute);
        }

        # Breadcrump
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addRouteItem($this->translator->trans(/** @Ignored */sprintf("%s.list", $this->screenName)), $this->indexRoute);
        $breadcrumbs->addItem($this->translator->trans(/** @Ignored */sprintf("%s.%s", $this->screenName, $isAdd ? "new" : "edit")));

        return $this->render(sprintf($this->editTwig, $isAdd ? "add" : "edit"), array(
            'form' => $form->createView(), 'item' => $item
        ));
    }

    /**
     * @param Request $request
     * @param $itemID
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Request $request, $itemID)
    {
        $item = $this->em->getRepository($this->repo)->findForDelete($itemID);

        $this->exceptionIfNull($item);

        if ($item->isDeletable()) {
            $this->em->remove($item);
            $this->em->flush();
        } else {
            $this->addFlash('danger', $this->translator->trans(/** @Ignore */sprintf("%s.remove.error", $this->screenName)));
        }

        return $this->redirectToRoute($this->indexRoute);
    }
}