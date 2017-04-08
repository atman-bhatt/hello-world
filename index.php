<?php

	require 'lib/main.php';

	// echo phpinfo();
	$apiKey = 'jqva4vhp';
	$handle = curl_init('http://api.railwayapi.com/route/train/12555/apikey/'.$apiKey.'/');

	$options = array(
		CURLOPT_RETURNTRANSFER =>true,
	);

	curl_setopt_array($handle, $options);

	$result = curl_exec($handle);
	echo "<pre>"; print_r($result);
	exit;
?>