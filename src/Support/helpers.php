<?php

if (!function_exists('b64')) {
    /**
     * Get base64 string from path.
     *
     * @param string $path
     * @return void
     */
    function b64(string $path)
    {
        if (!file_exists($path)) return;

        $type   = pathinfo($path, PATHINFO_EXTENSION);
        $data   = file_get_contents($path);

        return 'data:application/' . $type . ';base64,' . base64_encode($data);
    }
}
