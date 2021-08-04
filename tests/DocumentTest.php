<?php

namespace GabrielChavezMe\Larafiel\Tests;

use GabrielChavezMe\Larafiel\ApiClient;
use GabrielChavezMe\Larafiel\Document;
use Orchestra\Testbench\TestCase;

class DocumentTest extends TestCase
{
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

        $this->assertIsObject($document);
    }
}