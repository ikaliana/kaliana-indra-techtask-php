<?php

// tests/Controller/LunchControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Model\Recipe;

class LunchControllerTest extends WebTestCase
{
    public function provideValidUrl()
	{
	    return [
	        ['/lunch'],
	        ['/lunch/2019-03-06'],
	    ];
	}

    public function provideInvalidUrl()
	{
	    return [
	        ['/lunch/mm-dd-yyyy'],
	        ['/lunch/12-31-2019'],
	    ];
	}

	/**
 	* @dataProvider provideValidUrl
	*/
    public function testGetMenu($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $response = $client->getResponse();

        //Assert that the response code is equal to 200
        $this->assertEquals(200, $response->getStatusCode());

        //Assert that the response content type is json
        $this->assertTrue(
    		$response->headers->contains('Content-Type','application/json'),
    		'the "Content-Type" header is "application/json"'
		);

		//Asserts that a response content is a valid JSON string
		$this->assertJson($response->getContent());

		$responseData = json_decode($response->getContent(), true);

		//Asserts that the result is non-empty array
		$this->assertGreaterThan(0, count($responseData));
    }

	/**
 	* @dataProvider provideInvalidUrl
	*/
    public function testInvalidDate($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        //Assert that the response code is equal to 500
        $this->assertResponseStatusCodeSame(500);

    }

    public function testGetEmptyMenu() {
        $client = static::createClient();
        $client->request('GET', '/lunch/2019-04-01');
        $response = $client->getResponse();
		$responseData = json_decode($response->getContent(), true);

		//Asserts that the result is an empty array
		$this->assertEquals(0, count($responseData));
    }
}
