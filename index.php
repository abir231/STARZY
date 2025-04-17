<?php
// index.php in root directory (C:\xamppa\htdocs\chaima\index.php)

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/LiveController.php';

// Simple router
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

// Remove trailing slash if exists
if ($path != '/' && substr($path, -1) == '/') {
    $path = substr($path, 0, -1);
}

// Route the request
switch ($path) {
    case '/':
        // Redirect to the FrontOffice/index.php
        header('Location: views/index.php');
        break;
        
    case '/live':
    case '/live.php':
        $controller = new LiveController();
        $controller->index();
        break;
        
    default:
        // Check if file exists
        $filepath = __DIR__ . $path;
        if (file_exists($filepath) && !is_dir($filepath)) {
            // Serve the file directly
            $ext = pathinfo($filepath, PATHINFO_EXTENSION);
            
            switch ($ext) {
                case 'css':
                    header('Content-Type: text/css');
                    break;
                case 'js':
                    header('Content-Type: application/javascript');
                    break;
                case 'jpg':
                case 'jpeg':
                    header('Content-Type: image/jpeg');
                    break;
                case 'png':
                    header('Content-Type: image/png');
                    break;
                case 'gif':
                    header('Content-Type: image/gif');
                    break;
            }
            
            readfile($filepath);
        } else {
            // 404 Not Found
            header('HTTP/1.1 404 Not Found');
            echo '404 - Page Not Found';
        }
        break;
}
?>