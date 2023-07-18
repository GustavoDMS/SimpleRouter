<?php

namespace gustavodms\simplerouter;

class ResponseWriter
{
    public function write(string $content): void
    {
        echo $content;
    }

    public function toJson(mixed $content): void
    {
        echo json_encode($content);
    }
}