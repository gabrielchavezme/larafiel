<?php

namespace GabrielChavezMe\Larafiel\Tests;

use GabrielChavezMe\Larafiel\ApiClient;
use GabrielChavezMe\Larafiel\Document;
use Orchestra\Testbench\TestCase;

class DocumentTest extends TestCase
{
    public $document;

    public function testGetAllDocuments()
    {
        $documents = Document::all();

        $this->assertIsArray($documents);
    }

    public function testCreateDocument()
    {
        $document = new Document([
            'file_path' => __DIR__ . '/fixtures/example.pdf',
            'signatories' => [
                [
                    'name' => 'Prueba',
                    'email' => rand(1,10000) . '@gmail.com',
                    'tax_id' => 'AAA010102AAA'
                ]
            ]
        ]);

        $document->save();

        $this->document = $document;

        $this->assertIsObject($document);
    }

    public function testDownloadDocument()
    {
        $document = Document::find("05291b96-8925-4034-82d7-c42457fcfc25");

        $this->assertIsString($document->saveFile('fixtures'));

        
    }
}