<?php

namespace Wanjee\Shuwee\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class ParameterController
 * @package Wanjee\Shuwee\ConfigBundle\Controller
 *
 * @Route("/api")
 */
class ParameterController extends Controller
{
    /**
     * @Route("/parameters")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getParametersAction(Request $request)
    {
        // load all parameters
        $em = $this->getDoctrine()->getManager();

        $list = $em->getRepository('ShuweeConfigBundle:Parameter')->findAll();

        // Return as associative array to avoid JSON Hijacking
        $response = new JsonResponse(array('parameters' => $list));

        // allow JSONP
        $callback = $request->query->get('callback');
        if (!is_null($callback)) {
            $response->setCallback($callback);
        }

        $response->setPublic();
        $response->setMaxAge(300); // 5 minutes

        return $response;
    }

    /**
     * @Route("/parameters/{machineName}")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $machineName
     *
     * @return JsonResponse|NotFoundHttpException
     */
    public function getParameterAction(Request $request, $machineName)
    {
        // load parameter by machine name
        $filters = array(
            'machineName' => $machineName,
        );

        $em = $this->getDoctrine()->getManager();

        $parameter = $em->getRepository('ShuweeConfigBundle:Parameter')->findOneBy($filters);

        if (!$parameter) {
            throw $this->createNotFoundException();
        }

        // Return as associative array to avoid JSON Hijacking
        $response = new JsonResponse(array('parameter' => $parameter));

        // allow JSONP
        $callback = $request->query->get('callback');
        if (!is_null($callback)) {
            $response->setCallback($callback);
        }

        $response->setPublic();
        $response->setMaxAge(300); // 5 minutes

        return $response;
    }

}
