<?php

namespace GabrielChavezMe\Larafiel;

use GabrielChavezMe\Larafiel\BaseObject;
use GabrielChavezMe\Larafiel\Template;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Document extends BaseObject
{

  protected static $resourceName = 'documents';
  protected $multipart = true;

  public function save()
  {
    unset($this->values->file);
    if (isset($this->values->file_path)) {
      $this->file = [
        'filename' => basename($this->file_path),
        'contents' => fopen($this->file_path, 'r')
      ];
      unset($this->values->file_path);
    }
    parent::save();
  }

  public function saveFile($path)
  {
    if (!$path) {
      throw new InvalidArgumentException('The path argument is required.');
    }

    $response = ApiClient::get(
      static::$resourceName . '/' . $this->id . '/file'
    );

    $filename = Str::random(40) . '.pdf';
    $path = Storage::putFileAs($path, $response->getBody(), $filename);

    return $path;
  }

  public function saveFileSigned($path)
  {
    if (!$path) {
      throw new InvalidArgumentException('The path argument is required.');
    }

    $response = ApiClient::get(
      static::$resourceName . '/' . $this->id . '/file_signed',
    );

    $filename = Str::random(40) . '.pdf';
    $path = Storage::putFileAs($path, $response->getBody(), $filename);

    return $path;
  }

  public function saveXML($path)
  {
    if (!$path) {
      throw new InvalidArgumentException('The path argument is required.');
    }

    $response = ApiClient::get(
      static::$resourceName . '/' . $this->id . '/xml'
    );

    $filename = Str::random(40) . '.xml';
    $path = Storage::putFileAs($path, $response->getBody(), $filename);

    return $path;
  }

  public static function createFromTemplate($args)
  {
    $requiredKeys = [
      'template_id' => 'string',
      'name' => 'string',
      'fields' => 'array',
      'signatories' => 'array',
      'external_id' => 'string'
    ];
    self::checkRequiredArgs($requiredKeys, $args);
    ApiClient::post(
      Template::resourceName() . '/' . $args['template_id'] . '/generate_document',
      $args,
      false
    );
  }

  public static function createManyFromTemplate($args)
  {
    $requiredKeys = [
      'template_id' => 'string',
      'identifier' => 'string',
      'callback_url' => 'string',
      'documents' => 'array'
    ];
    self::checkRequiredArgs($requiredKeys, $args);
    ApiClient::post(
      Template::resourceName() . '/' . $args['template_id'] . '/generate_documents',
      $args,
      false
    );
  }
}
