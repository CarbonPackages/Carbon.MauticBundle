<?php

namespace MauticPlugin\MauticCarbonBundle\Controller\Api;

use Mautic\CoreBundle\Controller\CommonController;
use Symfony\Component\HttpFoundation\Response;

class ToolingApiController extends CommonController
{
    /**
     * Send example emails to recipients
     *
     * @return Response
     */
    public function pingAction(): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(
            json_encode([
                'success' => 1,
                'ping' => 'pong',
            ]),
        );

        return $response;
    }
}
