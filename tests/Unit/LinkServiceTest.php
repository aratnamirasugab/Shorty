<?php

namespace Tests\Unit;

use App\Http\Services\LinkService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LinkServiceTest extends TestCase
{
    public function test_should_return_url()
    {
        $code = 'aaaaaa';
        $service = new LinkService();

        $this->assertContains('http', $service->addHttpUrl($code));
    }

    public function test_should_return_empty_string()
    {
        $code = 'dowkdowokodw';
        $service = new LinkService();

        $this->assertEmpty($service->addHttpUrl($code));
    }

    public function test_should_return_data_url()
    {
        $code = 'aaaaaa';
        $service = new LinkService();

        $this->assertObjectHasAttribute('id', $service->findShortcode($code));
    }

    public function test_should_return_empty_data_url()
    {
        $code = 'mokdowdw';
        $service = new LinkService();

        $this->assertEmpty($service->findShortcode($code));
    }

}
