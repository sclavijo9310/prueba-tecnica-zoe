<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetContactTest extends TestCase
{
    use RefreshDatabase;

    private $_rowsNumber = 5;

    protected function setUp(): void
    {
        parent::setUp();

        factory(\App\Contact::class, $this->_rowsNumber)->create();
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetContacts()
    {
        $response = $this->get('/api/contacts');

        $response->assertStatus(200);
        $this->assertJson($response->content(), 'Response is valid JSON');
        $response->assertJsonCount($this->_rowsNumber);
    }
}
