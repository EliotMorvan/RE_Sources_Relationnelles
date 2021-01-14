<?php

namespace Http;

class Response
{
    /**
     * Redirects to the given url.
     * 
     * @param string $url
     */
    public static function redirect(string $url): void
    {
        http_response_code(302); // Code de redirection temporaire
        header('Location: ' . $url);
        exit;
    }
}