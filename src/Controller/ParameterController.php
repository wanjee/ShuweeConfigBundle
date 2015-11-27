<?php

namespace Wanjee\Shuwee\ConfigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        $parameters = $this->container->get('shuwee_config.manager')->all();

        // Return as associative array to avoid JSON Hijacking
        $response = new JsonResponse(array('parameters' => $parameters));

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
        $parameterValue = $this->container->get('shuwee_config.manager')->get($machineName);

        if (!$parameterValue) {
            throw $this->createNotFoundException();
        }

        // Return as associative array to avoid JSON Hijacking
        $response = new JsonResponse(array('value' => $parameterValue));

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
