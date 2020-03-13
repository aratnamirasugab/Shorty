<?php

namespace App\Http\Services;

use App\Http\Repositories\LinkRepository;

class LinkService {

    public function __construct()
    {
        $this->repository = new LinkRepository();
    }

    public function addHttpUrl($code)
    {
        $urlRetrieved = $this->repository->searchShortcode($code);
        if (empty($urlRetrieved)) {
            return '';
        }
        return 'http://' . $urlRetrieved->url;
    }

    public function findShortcode($code)
    {
        $dataRetrieved = $this->repository->searchShortcode($code);
        
        if (empty($dataRetrieved)) {
            return '';
        }
        return $dataRetrieved;
    }   

    public function generateRandomChar()
    {
        $allowedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';   
        $randomChar = substr(str_shuffle($allowedChars), 0, 6);
        return $randomChar;
    }

    public function checkShortcodeWithRegex($shortcode)
    {
        $res = preg_match('/^[0-9a-zA-Z_]{6}$/', $shortcode);
        return $res;
    }

    public function store($shortcode, $url)
    {
        if (empty($shortcode)) {
            $shortcode = $this->generateRandomChar();
        }

        $shortcodeExist = $this->repository->searchShortcode($shortcode);
        if ($shortcodeExist != null) {
            return [
                'message' => 'The the desired shortcode is already in use. Shortcodes are case-sensitive.',
                'status_code' => 409
            ];
        }
        
        $result = $this->repository->addNewShortcode($url, $shortcode);

        if ($result > 0)
        {
            return [
                'message' => $shortcode,
                'status_code' => 201
            ];
        } else {
            return [
                'message' => 'failed insert to db',
                'status_code' => 422
            ];
        }
    }

}