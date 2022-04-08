<?php

namespace App\Controller;

use App\Service\GetDistanceBetweenPointsService;

class GetDistanceBetweenPointsController
{
    public function __construct(
        private GetDistanceBetweenPointsService $getDistanceBetweenPointsService
    ) {}

    public function processRequest(
        string $requestMethod,
        float $firstLatitude,
        float $firstLongitude,
        float $secondLatitude,
        float $secondLongitude
    ): void
    {
        switch ($requestMethod) {
            case 'GET':
                $response = $this->getDistanceBetweenPointsService->getDistance(
                    $firstLatitude,
                    $firstLongitude,
                    $secondLatitude,
                    $secondLongitude
                );
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        header('Content-type: application/json');
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function notFoundResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}