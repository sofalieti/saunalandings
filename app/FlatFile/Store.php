<?php

namespace App\FlatFile;

use Illuminate\Support\Facades\File;

/**
 * Atomic JSON read/write for content/ files.
 */
class Store
{
    /**
     * @return string
     */
    public function contentPath()
    {
        return rtrim(config('flat.content_path'), DIRECTORY_SEPARATOR);
    }

    /**
     * Ensure content directory exists.
     */
    public function ensureContentDir()
    {
        $path = $this->contentPath();
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    /**
     * @param string $relativePath path under content/
     * @return array|null
     */
    public function read($relativePath)
    {
        $full = $this->fullPath($relativePath);
        if (!File::exists($full)) {
            return null;
        }

        $json = File::get($full);
        $data = json_decode($json, true);

        return is_array($data) ? $data : null;
    }

    /**
     * @param string $relativePath
     * @param array  $data
     */
    public function write($relativePath, array $data)
    {
        $full = $this->fullPath($relativePath);
        $dir = dirname($full);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $tmp = $full . '.' . uniqid('tmp', true) . '.tmp';
        File::put($tmp, $json . "\n");

        // Atomic replace where possible
        if (File::exists($full)) {
            File::delete($full);
        }
        rename($tmp, $full);
    }

    /**
     * @param string $relativePath
     */
    public function delete($relativePath)
    {
        $full = $this->fullPath($relativePath);
        if (File::exists($full)) {
            File::delete($full);
        }
    }

    /**
     * Delete a directory under content/ recursively.
     *
     * @param string $relativeDir
     */
    public function deleteDirectory($relativeDir)
    {
        $full = $this->fullPath($relativeDir);
        if (File::isDirectory($full)) {
            File::deleteDirectory($full);
        }
    }

    /**
     * Glob relative paths under content/.
     *
     * @param string $pattern e.g. brands/{slug}/brand.json with wildcards
     * @return array list of relative paths
     */
    public function glob($pattern)
    {
        $base = $this->contentPath();
        $matches = glob($base . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $pattern));
        if (!$matches) {
            return [];
        }

        $result = [];
        $prefixLen = strlen($base) + 1;
        foreach ($matches as $full) {
            $result[] = str_replace('\\', '/', substr($full, $prefixLen));
        }

        return $result;
    }

    /**
     * @param string $relativePath
     * @return string
     */
    public function fullPath($relativePath)
    {
        return $this->contentPath() . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);
    }
}
