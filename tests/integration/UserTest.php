<?php

namespace GabrielChavezMe\Larafiel\Tests\Integration;

use GabrielChavezMe\Larafiel\API\ApiClient;
use GabrielChavezMe\Larafiel\API\User;
use GabrielChavezMe\Larafiel\Tests\Integration\MiFielTests;

class UserTest extends MiFielTests
{

  /**
   * @group internet
   */
  public function testCreateUser()
  {
    $this->setTokens();
    $user = new User([
      'email' => 'some' . rand(1, 1000) . '@gmail.com'
    ]);
    $user->save();
    $this->assertEquals(null, $user->message);
    $this->assertEquals('success', $user->status);
  }
}
