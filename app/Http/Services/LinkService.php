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
        $shortcode = $this->repository->searchShortcode($code);
        $urlRedirect = 'http://' . $shortcode->url;
        return $urlRedirect;
    }

    public function findShortcode($code)
    {
        $shortcode = $this->repository->searchShortcode($code);
        return $shortcode;
    }

    public function incrementCounter($code)
    {
        $this->repository->addRedirectCountByOne($code);
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
            // generate new
            $shortcode = $this->generateRandomChar();
        }

        // check regex
        $shortcodeExist = $this->repository->searchShortcode($shortcode);
        if ($shortcodeExist != null) {
            // if found , return response already exists
            return [
                'message' => 'The the desired shortcode is already in use. Shortcodes are case-sensitive.',
                'status_code' => 409
            ];
        }
        
        // if valid, insert to db
        $result = $this->repository->addNewShortcode($url, $shortcode);

        // if successs insert to db, return response success
        if ($result > 0)
        {
            return [
                'message' => 'success',
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