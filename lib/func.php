<?php 
/**
 * @author Aatman Bhatt <[atmanb.dev@gmail.com]>
 * @author Yash Shah <[26yvshah@gmail.com]>
 * 
 * @version 1.0 [Functions required for the general operations, defined here for reusability.]
 */
define('API_KEY_RAILWAYAPI_COM', 'jqva4vhp');

/**
 * [void _final defines a php constant]
 * NOTE: all the constant names will get converted to uppercase
 * @param  [string] $constantName  [name of the variable]
 * @param  [any] $constantValue [value of the variable]
 */
function _final($constantName, $constantValue) {
	$constantName = strtoupper($constantName);
	if(!empty($constantName) && !empty($constantValue)) {
		define($constantName, $constantValue);
	}
}

/**
 * [getFormattedDate description]
 * @param  [string] $for  [for which function]
 * @param  [string] $date [Date to be formatted]
 * @return [string] $formattedDate [formatted date]
 */
function getFormattedDate($for, $date) {
	$dateObject = date_create_from_format('d-m-Y', $date);

	switch($for) {
		case 'trainsBetweenStations':
			$format = 'd-m';
			break;
		
		case 'trainFareEnquiry':
			$format = 'd-m-Y';
			break;

		default: 
			$format = 'd-m-Y';
			break;
	}

	$formattedDate = date_format($dateObject, $format);

	return $formattedDate;
}

/**
 * [getApiResponse description]
 * @param  [string] $url [description]
 * @return [mixed]       [description]
 */
function getApiResponse($url) {
	$response = false;

	$ch = curl_init($url);

	$options = array(
		CURLOPT_RETURNTRANSFER => true,
	);

	curl_setopt_array($ch, $options);

	$response = curl_exec($ch);

	return $response;
}


function formatResponse($response, $for) {
	$data = array('reqFrom'=>$for, 'result' => false);
	if(!empty($response)) {
		switch ($for) {
			case 'trainsBetweenStations':

				break;
		}
	}

	return json_encode($data);
}

/**
 * [trainsBetweenStations description]
 * @param  [string] $srcStnCode  [Source station code]
 * @param  [string] $destStnCode [Destination station code]
 * @param  [string] $date        [Search on date, format - dd-mm]
 * @return [json]   $returnData
 */
function trainsBetweenStations($srcStnCode, $destStnCode, $date) {
	$formattedDate = getFormattedDate('trainsBetweenStations', $date);
	$reqUrl = 'http://api.railwayapi.com/between/source/'.$srcStnCode.'/dest/'.$destStnCode.'/date/'.$formattedDate.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response = getApiResponse($reqUrl);

	$returnData = formatResponse($response, 'trainsBetweenStations');

	return $returnData;
}

/**
 * [pnrStatus description]
 * @param  [string] $p [pnr_number]
 * @return [json]   $returnData
 */
function pnrStatus($p) {
	$reqUrl = 'http://api.railwayapi.com/pnr_status/pnr/'.$p.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [trainFareEnquiry description]
 * @param  [string] $train        
 * @param  [string] $srcStnCode   
 * @param  [string] $destStnCode  
 * @param  [string] $age          
 * @param  [string] $quota        
 * @param  [string] $dateOfJourney
 * @return [json]   $returnData   
 */
function trainFareEnquiry($train, $srcStnCode, $destStnCode, $age, $quota, $dateOfJourney) {
	$formattedDate = getFormattedDate('trainFareEnquiry', $dateOfJourney);

	$reqUrl = 'http://api.railwayapi.com/fare/train/'.$train.'/source/'.$srcStnCode.'/dest/'.$destStnCode.'/age/'.$age.'/quota/'.$quota.'/doj/'.$formattedDate.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [trainArrivals description]
 * @param  [string] $stationCode
 * @param  [integer] $hours - Possible values either 2 or 4
 * @return [json]    $returnData
 */
function trainArrivals($stationCode, $hours) {
	$reqUrl = 'http://api.railwayapi.com/arrivals/station/'.$stationCode.'/hours/'.$hours.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [stationAutocompleteSuggest description]
 * @param  [string] $searchQuery
 * @return [json]             
 */
function stationAutocompleteSuggest($searchQuery) {
	$reqUrl = 'http://api.railwayapi.com/suggest_station/name/'.$searchQuery.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [trainAutocompleteSuggest description]
 * @param  [string] $searchQuery
 * @return [json]             
 */
function trainAutocompleteSuggest($searchQuery) {
	$reqUrl = 'http://api.railwayapi.com/suggest_train/trains/'.$searchQuery.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [getLiveTrainStatus description]
 * @param  [type] $trainNumber   [description]
 * @param  [type] $dateOfJourney [yyyymmdd]
 * @return [type]                [description]
 */
function getLiveTrainStatus($trainNumber, $dateOfJourney) {
	$formattedDate = getFormattedDate('getLiveTrainStatus', $dateOfJourney);
	$reqUrl = 'http://api.railwayapi.com/live/train/<train number>/doj/'.$formattedDate.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [getSeatAvailability description]
 * @param  [type] $trainNumber   
 * @param  [type] $sourceCode    
 * @param  [type] $destCode      
 * @param  [type] $dateOfJourney [DD-MM-YYYY]
 * @param  [type] $classCode     
 * @param  [type] $quotaCode     
 * @return [type]                
 */
function getSeatAvailability($trainNumber, $sourceCode, $destCode, $dateOfJourney, $classCode, $quotaCode) {
	$formattedDate = getFormattedDate('getSeatAvailability', $dateOfJourney); // DD-MM-YYYY
	$reqUrl = 'http://api.railwayapi.com/check_seat/train/'.$trainNumber.'/source/'.$sourceCode.'/dest/'.$destCode.'/date/'.$formattedDate.'/class/'.$classCode.'/quota/'.$quotaCode.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [trainRouteInfo description]
 * @param  [type] $trainNumber [description]
 * @return [type]              [description]
 */
function trainRouteInfo($trainNumber) {
	$reqUrl = 'http://api.railwayapi.com/route/train/'.$trainNumber.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [getTrainInfo description]
 * @param  [type] $trainNumber [description]
 * @return [type]              [description]
 */
function getTrainInfo($trainNumber) {
	$reqUrl = 'http://api.railwayapi.com/name_number/train/'.$trainNumber.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [stationNameToCode description]
 * @param  [type] $stationName [description]
 * @return [type]              [description]
 */
function stationNameToCode($stationName) {
	$reqUrl = 'http://api.railwayapi.com/name_to_code/station/'.$stationName.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [cancelledTrains description]
 * @param  [type] $date [description]
 * @return [type]       [description]
 */
function cancelledTrains($date) {
	$formattedDate = getFormattedDate('cancelledTrains', $date); // dd-mm-yyyy
	$reqUrl = 'http://api.railwayapi.com/cancelled/date/'.$formattedDate.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}

/**
 * [rescheduledTrains description]
 * @param  [type] $date [description]
 * @return [type]       [description]
 */
function rescheduledTrains($date) {
	$formattedDate = getFormattedDate('rescheduledTrains', $date); // dd-mm-yyyy
	$reqUrl = 'http://api.railwayapi.com/cancelled/date/'.$formattedDate.'/apikey/'.API_KEY_RAILWAYAPI_COM.'/';

	$response   = getApiResponse($reqUrl);
	$returnData = formatResponse($response, 'pnrStatus');

	return $returnData;
}
?>