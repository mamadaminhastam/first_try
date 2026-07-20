<?php

if (!function_exists('token_icon')) {
    /**
     * Generate an image tag for a token symbol with fallback.
     *
     * @param string $symbol
     * @param int    $size
     * @return string
     */
    function token_icon($symbol, $size = 20)
    {
        $url = asset('icons/tokens/' . strtolower($symbol) . '.svg');
        $fallback = asset('icons/tokens/generic.svg');
        return "<img src='{$url}' width='{$size}' height='{$size}' alt='{$symbol}' style='vertical-align:middle; margin-right:4px;' onerror=\"this.onerror=null;this.src='{$fallback}';\">";
    }
}
