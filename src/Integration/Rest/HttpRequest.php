<?php
/**
 * @copyright Tonic Works (c) 2015-
 */

namespace TonicWorks\Quotexpress\Integration\Rest;

use TonicWorks\Quotexpress\Exception\QxException;

class HttpRequest {
    protected $baseUrl;
    protected $username = null;
    protected $password;

    public function __construct($baseUrl, $username, $password) {
        $this->baseUrl  = $baseUrl;
        if (substr($this->baseUrl, -1) != '/') {
            $this->baseUrl .= "/";
        }
        $this->username = $username;
        $this->password = $password;
    }

    protected function makeUrl($uri) {
        return $this->baseUrl . $uri;
    }

    protected function getHttpUserPass() {
        return $this->username . ":" . $this->password;
    }

    public function submitPost($uri, $request) {
        $url = $this->makeUrl($uri);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request, '', '&'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        if ($this->username !== null) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $this->getHttpUserPass());
        }
        $raw = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            throw new QxException("Error submitting POST: " . $code . " " . $url . ", ", $raw);
        } else {
            return $raw;
        }
    }

    public function submitPostJson($uri, $request) {
        $url = $this->makeUrl($uri);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($request), 'Expect: '));
        if ($this->username !== null) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $this->getHttpUserPass());
        }
        $raw = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            throw new QxException("Error submitting POST: " . $code . " " . $url . ", " . $raw);
        } else {
            return $raw;
        }
    }

    public function submitGet($uri) {
        $url = $this->makeUrl($uri);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($this->username !== null) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $this->getHttpUserPass());
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $raw = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            throw new QxException("Error submitting GET: " . $code . " " . $url . ", " . $raw);
        } else {
            return $raw;
        }
    }

    public function submitPut($uri, $request) {
        $url = $this->makeUrl($uri);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request, '', '&'));
        if ($this->username !== null) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $this->getHttpUserPass());
        }
        $raw = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            throw new QxException("Error submitting PUT: " . $code . " " . $url . ", " . $raw);
        } else {
            return $raw;
        }
    }


    public function submitPutJson($uri, $request) {
        $url = $this->makeUrl($uri);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($request), 'Expect: '));
        if ($this->username !== null) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $this->getHttpUserPass());
        }
        $raw = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            throw new QxException("Error submitting PUT: " . $code . " " . $url . ", " . $raw);
        } else {
            return $raw;
        }
    }

    public function submitPatchJson($uri, $request) {
        $url = $this->makeUrl($uri);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($request), 'Expect: '));
        if ($this->username !== null) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $this->getHttpUserPass());
        }
        $raw = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            throw new QxException("Error submitting PATCH: " . $code . " " . $url . ", " . $raw);
        } else {
            return $raw;
        }
    }
}
 