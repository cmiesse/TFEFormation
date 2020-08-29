<?php
namespace TIC\PlatformBundle\Controller;

use TIC\PlatformBundle\Entity\ClientsCategories;
use TIC\PlatformBundle\Form\ClientCategoryFormType;

class ClientCategoryController extends ParameterController
{
    public function setRequiredNames()
    {
        $this->repo = "TICPlatformBundle:ClientsCategories";
        $this->indexTwig = "TICPlatformBundle:ClientCategory:view.html.twig";
        $this->editTwig = "TICPlatformBundle:ClientCategory:%s.html.twig";
        $this->indexRoute = "tic_platform_main_client_category_index";
        $this->screenName = "client.category";
        $this->emptyObject = new ClientsCategories();
        $this->formType = new ClientCategoryFormType(true);
    }
}