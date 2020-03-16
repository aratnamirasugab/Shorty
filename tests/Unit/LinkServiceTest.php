<?php

namespace Tests\Unit;

use App\Http\Services\LinkService;
use Tests\TestCase;

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

    public function test_should_return_random_char()
    {
        $service = new LinkService();
        $random = $service->generateRandomChar();
        $this->assertRegExp('/^[0-9a-zA-Z_]{6}$/', $random);
    }

    public function test_should_1_check_with_regex()
    {
        $shortcode = 'aaaaaa';
        $service = new LinkService();
        $this->assertEquals(1, $service->checkShortcodeWithRegex($shortcode));
    }

    // public function test_store()
    // {
    //     $service = new LinkService();
        

    // }


}
