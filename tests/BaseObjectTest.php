<?php

namespace GabrielChavezMe\Larafiel\Tests;

use GabrielChavezMe\Larafiel\API\ApiClient;
use GabrielChavezMe\Larafiel\API\BaseObject;
use GabrielChavezMe\Larafiel\Exceptions\ArgumentError;
use PHPUnit\Framework\TestCase;

class BaseObjectTest extends TestCase {
  public function testCheckRequiredArgsOK() {
    $required = [
      'some' => 'string',
      'other' => 'string',
      'arg' => 'array',
    ];
    $args = [
      'some' => 'blah',
      'other' => 'blah1',
      'arg' => ['some' => 'arg']
    ];
    $resp = BaseObject::checkRequiredArgs($required, $args);
    $this->assertEquals($resp, true);
  }

  public function testCheckRequiredArgsRequired() {
    $required = [
      'some' => 'string',
      'other' => 'string',
      'arg' => 'array',
    ];
    $args = [
      'some' => 'blah',
      'other' => 'blah1'
    ];
    $this->expectException(ArgumentError::class);
    BaseObject::checkRequiredArgs($required, $args);
  }

  public function testCheckRequiredArgsWrongType() {
    $required = [
      'some' => 'string',
      'other' => 'string',
      'arg' => 'array',
    ];
    $args = [
      'some' => 'blah',
      'other' => ['blah1'],
      'arg' => ['some']
    ];
    BaseObject::checkRequiredArgs($required, $args);
  }
}
