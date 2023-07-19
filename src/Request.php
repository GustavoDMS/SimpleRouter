<?php

namespace gustavodms\simplerouter;

    class Request
    {
        private ?array $params;
        private ?string $queryString;
        private ?array $bodyParams;

        private function __construct(?array $params = null, ?array $bodyParams = null, ?string $queryString = null)
        {
            $this->params = $params;
            $this->queryString = $queryString;
            $this->bodyParams = $bodyParams;
        }

        public static function Initialize($queryParams): Request
        {
            $queryString = $_SERVER['REQUEST_METHOD'];
            $method = $_SERVER['REQUEST_METHOD'];
            //$queryParams = $_GET;
            $bodyParams = [];

            $contentType = $_SERVER['CONTENT_TYPE'];

            if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
                if (str_contains($contentType, 'multipart/form-data')) {
                    $bodyParams = $_POST;
                } elseif (str_contains($contentType, 'application/x-www-form-urlencoded')) {
                    parse_str(file_get_contents('php://input'), $bodyParams);
                } elseif (str_contains($contentType, 'application/json')) {
                    $body = file_get_contents('php://input');
                    $bodyParams = json_decode($body, true);
                }
            }

            return new Request($queryParams, $bodyParams, $queryString);
        }

        public function Params(string $name, $default = null)
        {
            return $this->queryParams[$name] ?? $default;
        }

        public function Body(string $name, $default = null)
        {
            return $this->bodyParams[$name] ?? $default;
        }

        public function QuerString(string $name, $default = null)
        {
            return $this->queryString[$name] ?? $default;
        }
    }