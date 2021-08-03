<?php

namespace GabrielChavezMe\Larafiel\Tests;

use GabrielChavezMe\Larafiel\API\ApiClient as Mifiel;
use PHPUnit\Framework\TestCase;

class ApiClientTest extends TestCase {
  private $appId = '385d67ed1271279d521154b28e238af8683272fe';
  private $appSecret = 'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA==';
  private $url = 'https://sandbox.mifiel.com/api/v1/';

  public function testCreation() {
    Mifiel::setTokens($this->appId, $this->appSecret);

    $this->assertEquals($this->appId, Mifiel::appId());
    $this->assertEquals($this->appSecret, Mifiel::appSecret());
  }

  public function testSetters() {
    Mifiel::appId($this->appId);
    Mifiel::appSecret($this->appSecret);
    Mifiel::url($this->url);

    $this->assertEquals($this->appId, Mifiel::appId());
    $this->assertEquals($this->appSecret, Mifiel::appSecret());
    $this->assertEquals($this->url, Mifiel::url());
  }

  public function testGetClient() {
    $this->assertEquals('GuzzleHttp\Client', get_class(Mifiel::getClient()));
  }
}
