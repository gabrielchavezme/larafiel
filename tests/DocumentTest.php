<?php

namespace GabrielChavezMe\Larafiel\Tests;

use GabrielChavezMe\Larafiel\API\ApiClient;
use PHPUnit\Framework\TestCase;
use GabrielChavezMe\Larafiel\API\Document;

class DocumentTest extends TestCase
{
    public function testGetAllDocuments()
    {
        ApiClient::setTokens('385d67ed1271279d521154b28e238af8683272fe', 'Npqjeg4dI9bOQ1UKcYqQrmkm3qFxUYQZb6ccf+bvm0rLcCU0y1z+DdSYcDLuezgZ4W/NvnBR8jzQt9Gm54i0AA==');
        ApiClient::url('https://sandbox.mifiel.com/api/v1/');

        $documents = Document::all();

        $this->assertIsArray($documents);

    }
}