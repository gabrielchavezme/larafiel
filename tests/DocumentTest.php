<?php

namespace GabrielChavezMe\Larafiel\Tests;

use GabrielChavezMe\Larafiel\ApiClient;
use PHPUnit\Framework\TestCase;
use GabrielChavezMe\Larafiel\Document;

class DocumentTest extends TestCase
{
    public function setTokens()
    {
        ApiClient::setTokens('385d67ed1271279d521154b28e238af8683272fe', 'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA==');
        ApiClient::url('https://sandbox.mifiel.com/api/v1/');   
    }
    public function testGetAllDocuments()
    {
        $this->setTokens();
        $documents = Document::all();

        $this->assertIsArray($documents);
    }

    public function testCreateDocument()
    {
        $this->setTokens();

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