<?php

namespace GabrielChavezMe\Larafiel\Tests\Integration;

use GabrielChavezMe\Larafiel\API\ApiClient;
use GabrielChavezMe\Larafiel\API\Document;
use GabrielChavezMe\Larafiel\Tests\Integration\MiFielTests;

class DocumentCRUDTest extends MiFielTests {

  const ORIGINAL_HASH = 'f4dee35b52fc06aa9d47f6297c7cff51e8bcebf90683da234a07ed507dafd57b';
  private static $id;

  public function getDocument() {
    $this->setTokens();
    if (self::$id) {
      return Document::find(self::$id);
    }
    $documents = Document::all();
    return reset($documents);
  }

  /**
   * @group internet
   */
  public function testSaveCreate() {
   $this->setTokens();
    $document = new Document([
      'original_hash' => self::ORIGINAL_HASH,
      'name' => 'some.pdf',
      'signatories' => [
        [ 'email' => 'paco@mifiel.com' ],
        [ 'email' => 'pedro@mifiel.com' ]
      ]
    ]);
    $document->save();
    self::$id = $document->id;
    // Fetch document again
    $document = $this->getDocument();
    $this->assertEquals(self::ORIGINAL_HASH, $document->original_hash);
  }

  /**
   * @group internet
   */
  public function testSaveDocCreate() {
   $this->setTokens();
    $document = new Document([
      'file_path' => __DIR__ . '../fixtures/example.pdf'
    ]);
    $document->save();
    self::$id = $document->id;
    // Fetch document again
    $document = $this->getDocument();
    $this->assertEquals(self::ORIGINAL_HASH, $document->original_hash);
  }

  /**
   * @group internet
   */
  public function testSaveFile() {
   $this->setTokens();
    $document = $this->getDocument();
    $path = __DIR__ . '../fixtures/example.pdf';
    $document->saveFile($path);
    $this->assertTrue(file_exists($path));
  }

  /**
   * @group internet
   */
  public function testSaveFileSigned() {
   $this->setTokens();
    $document = $this->getDocument();
    $path = __DIR__ . '../fixtures/the-file-signed.pdf';
    $document->saveFileSigned($path);
    $this->assertTrue(file_exists($path));
  }

  /**
   * @group internet
   */
  public function testSaveXml() {
   $this->setTokens();
    $document = $this->getDocument();
    $path = 'tmp/the-file.xml';
    $document->saveXml($path);
    $this->assertTrue(file_exists($path));
  }

  /**
   * @group internet
   */
  public function testSaveUpdate() {
    $document = $this->getDocument();
    $this->assertEquals('', $document->callback_url);
    $document->callback_url = "http://blah.com";
    $document->save();
    // Fetch document again
    $document_updated = $this->getDocument();
    $this->assertEquals("http://blah.com", $document_updated->callback_url);
  }

  /**
   * @group internet
   */
  public function testAll() {
   $this->setTokens();
    $documents = Document::all();
    $this->assertTrue(is_array($documents));
    $this->assertEquals(Document::class, get_class(reset($documents)));
  }

  /**
   * @group internet
   */
  public function testGetProperties() {
    $document = $this->getDocument();
    $this->assertEquals(self::$id, $document->id);
  }

  /**
   * @group internet
   */
  public function testSetProperties() {
    $document = $this->getDocument();
    $this->assertEquals(self::ORIGINAL_HASH, $document->original_hash);

    $original_hash = 'blah';
    $document->original_hash = $original_hash;
    $this->assertEquals($original_hash, $document->original_hash);
  }

  /**
   * @group internet
   */
  public function testDelete() {
    $documents = Document::all();
    foreach ($documents as $document) {
      Document::delete($document->id);
    }
    $documents = Document::all();
    $this->assertEmpty($documents);
  }
}
