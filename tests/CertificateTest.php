<?php

namespace GabrielChavezMe\Larafiel\Tests;

use GabrielChavezMe\Larafiel\API\ApiClient;
use GabrielChavezMe\Larafiel\API\Certificate;
use Mockery as m;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class CertificateTest extends TestCase {

  /**
   * @after
   **/
  public function allowMockeryAsertions() {
    if ($container = m::getContainer()) {
      $this->addToAssertionCount($container->mockery_getExpectationCount());
    }
  }

  public function testCreate() {
    $certificate = new Certificate([
      'file_path' => './tests/fixtures/FIEL_AAA010101AAA.cer'
    ]);

    $this->assertTrue($certificate->save());
  }

  public function testUpdate() {
    $certificate = new Certificate();
    $certificate->id = '07320f00-f504-47e0-8ff6-78378d2faca4';

    $this->assertTrue($certificate->save());
  }

  public function testAll() {
    $mockResponse = m::mock('\GuzzleHttp\Psr7\Response');
    $mockResponse->shouldReceive('getBody')
                 ->once()
                 ->andReturn('[{"id": "some-id"}]');
    m::mock(ApiClient::class)
      ->shouldReceive('get')
      ->with('keys')
      ->andReturn($mockResponse)
      ->once();

    $certificates = Certificate::all();
  }

  public function testFind() {
    $mockResponse = m::mock('\GuzzleHttp\Psr7\Response');
    $mockResponse->shouldReceive('getBody')
                 ->once()
                 ->andReturn('{"id": "some-id"}');
    m::mock(ApiClient::class)
      ->shouldReceive('get')
      ->with('keys/some-id')
      ->andReturn($mockResponse)
      ->once();

    Certificate::find('07320f00-f504-47e0-8ff6-78378d2faca4');
  }

  public function testSetGetProperties() {
    $certificate = new Certificate([
      'certificate_number' => '20001000000200001410'
    ]);
    $this->assertEquals('20001000000200001410', $certificate->certificate_number);

    $certificate_number = 'blah';
    $certificate->certificate_number = $certificate_number;
    $this->assertEquals($certificate_number, $certificate->certificate_number);
  }

  public function testDelete() {
    m::mock(ApiClient::class)
      ->shouldReceive('delete')
      ->with('keys/some-id')
      ->andReturn(new \GuzzleHttp\Psr7\Response)
      ->once();

    Certificate::delete('some-id');
  }

  public function testSat() {
    m::mock(ApiClient::class)
      ->shouldReceive('get')
      ->with('keys/sat')
      ->andReturn(new \GuzzleHttp\Psr7\Response)
      ->once();

    Certificate::sat();
  }

}