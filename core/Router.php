<?php
/**
 * ==============================================================================
 * CORE: Router (Enrutador)
 * ==============================================================================
 */
class Router {
    private $routes = [];

    public function get(string $path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri) {
        // Limpiar query string
        $path = parse_url($uri, PHP_URL_PATH);
        // Si el proyecto está en un subdirectorio, podrías necesitar ajustar el path.
        // Asumimos base path dinámico o '/'
        $baseDir = dirname($_SERVER['SCRIPT_NAME']);
        if ($baseDir !== '/' && strpos($path, $baseDir) === 0) {
            $path = substr($path, strlen($baseDir));
        }
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }
        if (empty($path)) {
            $path = '/';
        }

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            if (is_array($handler)) {
                $controller = new $handler[0]();
                $methodName = $handler[1];
                return $controller->$methodName();
            }
            return call_user_func($handler);
        }

        // Buscar coincidencia con rutas parametrizadas (ej: /mapa/{slug})
        foreach ($this->routes[$method] ?? [] as $routePattern => $handler) {
            if (strpos($routePattern, '{') !== false) {
                $patternRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $routePattern);
                $patternRegex = '#^' . $patternRegex . '$#';
                if (preg_match($patternRegex, $path, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    if (is_array($handler)) {
                        $controller = new $handler[0]();
                        $methodName = $handler[1];
                        return $controller->$methodName($params);
                    }
                    return call_user_func($handler, $params);
                }
            }
        }

        // Manejar 404
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "<p>La ruta $path no existe.</p>";
    }
}
