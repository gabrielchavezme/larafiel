<?php

namespace GabrielChavezMe\Larafiel;

use GuzzleHttp\Psr7\Request;
use Acquia\Hmac\Guzzle\HmacAuthMiddleware;
use Acquia\Hmac\RequestSigner;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GabrielChavezMe\Larafiel\Digest\ApiAuthGemDigest;
use Illuminate\Support\Facades\Log;

class ApiClient
{
  private static $client;

  public static function get($path, $params = array())
  {
    return self::request('GET', $path, $params);
  }

  public static function post($path, $params = array(), $multipart = false)
  {
    return self::request('POST', $path, $params, $multipart);
  }

  public static function delete($path)
  {
    return self::request('DELETE', $path);
  }

  public static function put($path, $params = array(), $multipart = false)
  {
    return self::request('PUT', $path, $params, $multipart);
  }

  private static function request($type, $path, $params = array(), $multipart = false)
  {
    self::setClient();
    $options = [];
    if ($multipart) {
      $options['multipart'] = self::build_multipart($params);
    } elseif (!empty($params)) {
      $options['json'] = $params;
    }
    // $options['headers'] = [
    //   'content-md5' => base64_encode(md5(json_encode($params), true))
    // ];
    return self::$client->request(strtoupper($type), $path, $options);
  }

  private static function build_multipart($params)
  {
    $multipart_arr = array();
    foreach ($params as $name => $value) {
      $field = self::build_field($name, $value);
      if ($field) {
        array_push($multipart_arr, $field);
      }
    }
    return $multipart_arr;
  }

  private static function build_field($name, $value)
  {
    if (is_array($value) && isset($value['filename'])) {
      return [
        'name'      => $name,
        'contents'  => $value['contents'],
        'filename'  => $value['filename']
      ];
    }
    if (!empty($value) && gettype($value) != 'NULL') {
      if (is_bool($value)) {
        $value = $value === true ? '1' : '0';
      } elseif (is_array($value) || is_object($value)) {
        $value = json_encode($value);
      }

      return [
        'name' => $name,
        'contents' => $value
      ];
    }
    return false;
  }

  public static function setClient()
  {
    $signer = new RequestSigner(new ApiAuthGemDigest());
    $signer->setProvider('APIAuth');

    $middleware = new HmacAuthMiddleware(
      $signer,
      env('MIFIEL_APP_ID'),
      env('MIFIEL_APP_SECRET')
    );

    $stack = HandlerStack::create();
    $stack->push($middleware);

    self::$client = new Client([
      'base_uri' => env('MIFIEL_API_URL'),
      'handler' => $stack,
    ]);
  }

  public static function getClient()
  {
    self::setClient();
    return self::$client;
  }
}
