<?php

namespace GabrielChavezMe\Larafiel\Tests;

use GabrielChavezMe\Larafiel\API\ApiClient;
use GabrielChavezMe\Larafiel\API\User;
use Mockery as m;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class UserTest extends TestCase {

  /**
   * @after
   **/
  public function allowMockeryAsertions() {
    if ($container = m::getContainer()) {
      $this->addToAssertionCount($container->mockery_getExpectationCount());
    }
  }

  public function testCreate() {
    $user = new User([
      'email' => 'some@email.com'
    ]);

    m::mock('alias:Mifiel\ApiClient')
      ->shouldReceive('post')
      ->with('users', m::type('Array'), false)
      ->andReturn(new \GuzzleHttp\Psr7\Response)
      ->once();

    $user->save();
  }

  public function testFind() {
    $mockResponse = m::mock('\GuzzleHttp\Psr7\Response');
    $mockResponse->shouldReceive('getBody')
                 ->once()
                 ->andReturn('{"id": "some-id"}');

    $this->expectException('\Exception');
    User::find('some-id');
  }

  public function testDelete() {
    $this->expectException('\Exception');

    User::delete('some-id');
  }
}
