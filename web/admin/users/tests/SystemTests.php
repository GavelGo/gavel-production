<?php

use PHPUnit\Framework\TestCase;

class SystemTest extends TestCase {
	
	// 404 page
	public function test404StatusCode(): void {
		$url = "http://gavelgo.com/notfound";
		$handle = curl_init($url);
		curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

		// Get the HTML or whatever is linked in $url
		$response = curl_exec($handle);
		// Check for 404
		$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);

		echo "\n" . $httpCode;
        $this->assertEquals($httpCode, '400');
    }

}

?>