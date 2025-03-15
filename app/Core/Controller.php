<?php

// app/Core/Controller.php

namespace App\Core;
use Exception;

class Controller
{
    /**
     * Render a view
     */
    protected function view(string $name, array $data = [])
    {
        extract($data);

        $viewPath = "../app/Views/{$name}.php";

        if (!file_exists($viewPath)) {
            throw new Exception("View {$name} not found");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Check if layout exists
        $layoutPath = "../app/Views/layouts/main.php";
        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            echo $content;
        }
    }

    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    /**
     * Redirect to another URL
     */
    protected function redirect(string $url)
    {
        header("Location: {$url}");
        exit;
    }
}