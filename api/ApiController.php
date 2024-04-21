<?php declare(strict_types=1);

namespace api;

class ApiController {

    private const API = 'https://openexchangerates.org/api'; 
    public string $endpoint;
    public array $pathParams;
    public array $queryParams;
    
    public function __construct(string $endpoint, array $pathParams, array $queryParams = []) {
        $this->endpoint = $endpoint;
        $this->pathParams = $pathParams;
        $this->queryParams = $queryParams;
    }

    function checkAssoc($array) {
        $nonAssociative = count(array_filter(array_keys($array), 'is_string')) === 0;
        if ($nonAssociative) {
            return false;
        } else {
            return true;
        }
    }

    public function get() {
        $endpoint = $this->endpoint;

        $oxrUrl = self::API . "/$endpoint";

        if ($this->checkAssoc($this->pathParams) === true) {
            throw new \RuntimeException('pathParams should be not an associative array');
        }


        foreach ($this->pathParams as $param) {
            $oxrUrl .= "/$param";
        }

        foreach ($this->queryParams as $k => $param) {
            if ($k === array_key_first($this->queryParams)) {
                $oxrUrl .= "?$k=$param";
            } else {
                $oxrUrl .= "&$k=$param";
 
            } 
        }

        $endpoint = str_replace(".json", "", $endpoint);
        return $this->$endpoint($oxrUrl);

    }

    private function latest(string $oxrUrl) {
        // Open CURL session:
        $ch = curl_init($oxrUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Get the data:
        $json = curl_exec($ch);
        curl_close($ch);
        
        $json = json_decode($json);


        if (isset($json->error) && $json->error === true) {
            throw new \RuntimeException($json->description);
        }

        return $json;
    }

    private function convert(string $oxrUrl) {
        // Open CURL session:
        $ch = curl_init($oxrUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Get the data:
        $json = curl_exec($ch);
        curl_close($ch);
        
        $json = json_decode($json);

        if (isset($json->error) && $json->error === true) {
            throw new \RuntimeException($json->description);
        }

        return $json;
    }
}
