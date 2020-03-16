<?php

namespace Tests\Unit;

use App\Http\Repositories\LinkRepository;
use Tests\TestCase;

class LinkRepositoryTest extends TestCase
{
    public function test_return_searchShortcode()
    {
        $code = "aaaaaa";
        $repository = new LinkRepository();

        $this->assertIsObject($repository->searchShortcode($code));
        $this->assertObjectHasAttribute('id', $repository->searchShortcode($code));
        $this->assertObjectHasAttribute('url', $repository->searchShortcode($code));
        $this->assertObjectHasAttribute('shortcode', $repository->searchShortcode($code));
        $this->assertObjectHasAttribute('created_at', $repository->searchShortcode($code));
        $this->assertObjectHasAttribute('updated_at', $repository->searchShortcode($code));
    }

    public function test_return_addRedirectCountByOne()
    {
        $code = 'aaaaaa';
        $repository = new LinkRepository();
        $this->assertIsInt($repository->addRedirectCountByOne($code));
        $this->assertGreaterThanOrEqual(0, $repository->addRedirectCountByOne($code));
    }

    public function test_return_updateUpdatedAt()
    {
        $code= 'instag';
        $repository = new LinkRepository();

        $this->assertIsInt($repository->updateUpdatedAt($code));
        $this->assertGreaterThanOrEqual(0, $repository->updateUpdatedAt($code));        
    }

    public function test_addNewShortcode()
    {   
        $url = 'www.ralali.com';
        $randomChar = 'xxxxxx';
        $repository = new LinkRepository();

        $this->assertIsBool($repository->addNewShortcode($url, $randomChar));

    }


}
