<?php

namespace Tools\CustomBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MasterController extends Controller
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);

        $this->em = $container->get('doctrine')->getManager();
        $this->translator = $container->get('translator');
    }

    /**
     * @param Request $request
     */
    protected function RejectNonXHR(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new BadRequestHttpException('Call should be XHR');
        }
    }

    /**
     * @param $item
     */
    protected function exceptionIfNull($item)
    {
        if ($item === null) {
            throw $this->createNotFoundException();
        }
    }
}