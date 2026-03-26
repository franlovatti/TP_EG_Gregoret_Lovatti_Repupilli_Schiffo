<?php
/**
 * Load environment variables from .env file
 * 
 * This function reads the .env file and loads all variables
 * into $_ENV and available via getenv()
 */

function loadEnv($filePath = null)
{
    // If no path provided, use the root of the project
    if ($filePath === null) {
        $filePath = dirname(dirname(__FILE__)) . '/.env';
    }

    if (!file_exists($filePath)) {
    // En producción (Railway), el archivo no existe, así que simplemente retornamos
    return;
    }

    // Read the file line by line
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Skip comments and empty lines
        if (strpos(trim($line), '#') === 0 || trim($line) === '') {
            continue;
        }

        // Split on the first = sign
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Remove quotes if present
            if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                $value = substr($value, 1, -1);
            }

            // Set in both $_ENV and via putenv()
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

/**
 * Get environment variable value
 * 
 * @param string $key The environment variable key
 * @param mixed $default Default value if not found
 * @return mixed The environment variable value or default
 */
function env($key, $default = null)
{
    $value = getenv($key);
    
    if ($value === false) {
        return $default;
    }

    return $value;
}

// Auto-load .env file on include
loadEnv();
?>
