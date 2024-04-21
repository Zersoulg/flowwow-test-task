<?php declare(strict_types=1);

namespace api;

class ApiController {

    private const API = 'https://openexchangerates.org/api'; 
    public string $endpoint;
    public array $requiredParams;
    public array $params;
    
    public function __construct(string $endpoint, array $requiredParams, array $params = []) {
        $this->endpoint = $endpoint;
        $this->requiredParams = $requiredParams;
        $this->params = $params;
    }

    public function get() {
        $endpoint = $this->endpoint;

        $oxrUrl = self::API . "/$endpoint.json";

        foreach ($this->requiredParams as $k => $param) {
            if ($k === array_key_first($this->requiredParams)) {
                $oxrUrl .= "?$k=$param";
            } else {
                $oxrUrl .= "&$k=$param";

            }        
        }

        foreach ($this->params as $k => $param) {
            $oxrUrl .= "&$k=$param";
        }

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
}
