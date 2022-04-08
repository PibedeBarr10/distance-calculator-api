<?php

namespace App\Service;

class GetDistanceBetweenPointsService
{
	public function getDistance(
        float $firstLatitude,
        float $firstLongitude,
        float $secondLatitude,
        float $secondLongitude
    ): array
	{
		$r = 6371.071;
		$rlat1 = $this->degreesToRadians($firstLatitude);
		$rlat2 = $this->degreesToRadians($secondLatitude);
		$difflat = $rlat2 - $rlat1;
		$difflon = $this->degreesToRadians($secondLongitude - $firstLongitude);
		
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
}