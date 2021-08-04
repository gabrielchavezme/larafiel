<?php

namespace GabrielChavezMe\Larafiel\Tests;

use GabrielChavezMe\Larafiel\ApiClient;
use Orchestra\Testbench\TestCase;

class ApiClientTest extends TestCase
{
  public function testGetClient()
  {
    $this->assertEquals('GuzzleHttp\Client', get_class(ApiClient::getClient()));
  }
}
