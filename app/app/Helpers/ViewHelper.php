<?php

namespace App\Helpers;

class ViewHelper {
    /**
     * Render a view file with data and return the content.
     *
     * @param string $viewPath The path to the view file.
     * @param array $data Associative array of data to pass to the view.
     * @return string The rendered view content.
     * @throws \Exception If the view file cannot be found.
     */
    public static function renderView(string $viewPath, array $data = []): string
    {
        // Resolve the full path to the view file
        $path = __DIR__ . '/../resources/views/' . $viewPath;

        // If the view file does not exist, throw an exception
        if (!file_exists($path)) {
            throw new \Exception("View cannot be found at path: {$path}");
        }

        // Extract the data array to variables for the view
        extract($data);

        // Start output buffering to capture the included view file's content
        ob_start();

        // Include the view file, the data is extracted to variables
        require $path;

        // Get the content from the buffer and end buffering
        $content = ob_get_clean();

        // Return the captured content
        return $content;
    }
}
