<?php

namespace App\Service;

class GetDistanceBetweenPointsService
{
	public function __construct(
		private string $requestMethod,
		private float $firstLatitude,
		private float $firstLongitude,
		private float $secondLatitude,
		private float $secondLongitude
	) {}

    public function processRequest(): void
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getDistance();
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
	
	private function getDistance(): array
	{
		$r = 6371.071;
		$rlat1 = $this->degreesToRadians($this->firstLatitude);
		$rlat2 = $this->degreesToRadians($this->secondLatitude);
		$difflat = $rlat2 - $rlat1;
		$difflon = $this->degreesToRadians($this->secondLongitude - $this->firstLongitude);
		
		$distance = 2 * $r * asin(
			sqrt(
				sin($difflat / 2) * sin($difflat / 2) + 
				cos($rlat1) * cos($rlat2) *
				sin($difflon / 2) * sin($difflon / 2)
			)
		);
		
		$response['status_code_header'] = 'HTTP/1.1 200 OK';
		$response['body'] = json_encode($distance);
		return $response;
	}
	
	private function degreesToRadians(float $degrees): float
	{
		return ($degrees * pi()) / 180;
	}
	
	private function notFoundResponse(): array
	{
		$response['status_code_header'] = 'HTTP/1.1 404 Not Found';
		$response['body'] = null;
		return $response;
	}
}