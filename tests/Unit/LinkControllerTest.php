<?php

namespace Tests\Unit;

use App\Http\Controllers\LinkController;
use Tests\TestCase;

class LinkControllerTest extends TestCase
{  
    public function test_should_return_200_showStats()
    {
        $controller = new LinkController();
        $code = 'aaaaaa';
        $status_code = $controller->showStats($code)->getStatusCode();
        
        $this->assertEquals(200, $status_code);
    }

    public function test_should_return_404_showStats()
    {
        $controller = new LinkController();
        $code = '12831231';
        $status_code = $controller->showStats($code)->getStatusCode();

        $this->assertEquals(404, $status_code);
    }

    public function test_should_return_302_showShortcode()
    {
        $controller = new LinkController();
        $code = 'instag';
        $status_code = $controller->showShortcode($code)->getStatusCode();

        $this->assertEquals(302, $status_code);
    }

    public function test_should_return_404_showShortcode()
    {
        $controller = new LinkController();
        $code  = 'djwidiwdj';
        $status_code = $controller->showShortcode($code)->getStatusCode();
        
        $this->assertEquals(404, $status_code);
    }

}
