<?php

if (!function_exists('require_routes')) {
    /**
     * Require routes list from routes/folder/*.php files
     *
     * @param string $path
     */
    function require_routes(string $path) : void
    {
        $lastSignInPath = substr($path, strlen($path) - 1, 1);
        if($lastSignInPath === "*") {
            // include any file from folder
            $pathWithoutStar = substr($path, 0, strlen($path) - 1);
            $dir = base_path("routes/" . $pathWithoutStar);
            $files = array_values(
                array_diff(scandir($dir), ['.', '..'])
            );
            foreach ($files as $file) {
                require_once $dir . $file;
            }
        } else {
            // include specific file if "*" is not found in path string
            require_once base_path("routes/{$path}.php");
        }
    }
}
