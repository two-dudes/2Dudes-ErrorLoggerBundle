<?php

namespace TwoDudes\ErrorLoggerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TwoDudesErrorLoggerBundle:Default:index.html.twig', array(
            'errors' => $this->get('two_dudes.error_logger')->getStorage()->fetchErrors()
        ));
    }

    public function showAction($id)
    {
        return $this->render('TwoDudesErrorLoggerBundle:Default:show.html.twig', array(
            'error' => $this->get('two_dudes.error_logger')->getStorage()->fetchError($id)
        ));
    }

    public function removeAction($id)
    {
        $this->get('two_dudes.error_logger')->getStorage()->removeError($id);

        return new RedirectResponse($this->generateUrl('two_dudes.errors.list'));
    }
}
