<?php
namespace TIC\PlatformBundle\Controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Tools\CustomBundle\Controller\MasterController;

class DocumentController extends MasterController
{
    /**
     * @param $documentID
     * @param $docType
     * @return BinaryFileResponse
     */
    public function downloadAction($documentID, $docType)
    {
        $document = $this->em->getRepository('TICPlatformBundle:Document')->find($documentID);
        $this->exceptionIfNull($document);

        $document->setInfoUpload($this->getParameter('upload_dir'), $docType);

        $response = new BinaryFileResponse($document->getAbsolutePath());
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $document->getDocumentOriginalName());

        return $response;
    }

    /**
     * @param Request $request
     * @param $trainerID
     * @param $documentID
     * @param $documentType
     * @return JsonResponse
     */
    public function removeAction(Request $request, $trainerID, $documentID, $documentType)
    {
        parent::RejectNonXHR($request);

        $document = $this->em->getRepository('TICPlatformBundle:Document')->findOneForDelete($trainerID, $documentID);

        if (null === $document) {
            throw $this->createNotFoundException();
        }

        $document->setInfoUpload($this->getParameter('upload_dir'), $documentType);
        if ($document->getTrainer() !== null) {
            $document->getTrainer()->removeDocumentsIdentityCard($document);
            $document->setTrainer(null);
        } else {
            if (count($document->getTrainerCV()->toArray()) > 0) {
                $document->getTrainerCV()[0]->setDocumentCV(null);
                $document->getTrainerCV()->clear();
            }
        }
        $this->em->remove($document);
        $this->em->flush();

        return new JsonResponse();
    }
}