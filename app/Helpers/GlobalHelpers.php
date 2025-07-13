<?php

use App\Models\Department;

// Existing functions
function listDepartment()
{
    $departments = Department::where('is_active', true)->get();
    return $departments;
}

function toEmbedUrl($url)
{
    if (strpos($url, 'youtube.com/watch') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        return 'https://www.youtube.com/embed/' . ($params['v'] ?? '');
    }

    if (strpos($url, 'youtu.be/') !== false) {
        $id = substr(parse_url($url, PHP_URL_PATH), 1);
        return 'https://www.youtube.com/embed/' . $id;
    }

    if (strpos($url, 'vimeo.com/') !== false) {
        $id = basename(parse_url($url, PHP_URL_PATH));
        return 'https://player.vimeo.com/video/' . $id;
    }

    if (strpos($url, 'drive.google.com/file/d/') !== false) {
        preg_match('/\/file\/d\/([^\/]+)\//', $url, $matches);
        return isset($matches[1])
            ? 'https://drive.google.com/file/d/' . $matches[1] . '/preview'
            : $url;
    }

    return $url;
}

function videoThumbnail($url)
{
    $videoId = null;

    if (strpos($url, 'youtube.com/watch') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        $videoId = $params['v'] ?? null;
    }

    if (strpos($url, 'youtu.be/') !== false) {
        $videoId = substr(parse_url($url, PHP_URL_PATH), 1);
    }

    if ($videoId) {
        $maxres = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
        $hq = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";

        if (@getimagesize($maxres)) {
            return $maxres;
        }
        return $hq;
    }

    return null;
}

// New asset path resolution functions
if (!function_exists('resolveAssetPath')) {
    /**
     * Resolves the correct asset path whether it's local storage or external URL
     *
     * @param string|null $path
     * @return string
     */
    function resolveAssetPath(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        // Check if it's already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Handle local storage path
        return asset('storage/' . ltrim($path, '/'));
    }
}

if (!function_exists('isExternalUrl')) {
    /**
     * Checks if a given path is an external URL
     *
     * @param string|null $path
     * @return bool
     */
    function isExternalUrl(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        return filter_var($path, FILTER_VALIDATE_URL) !== false;
    }
}

if (!function_exists('storeFileAndGetPath')) {
    /**
     * Stores uploaded file and returns the storage path
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string
     */
    function storeFileAndGetPath($file, string $directory = 'uploads'): string
    {
        $path = $file->store("public/{$directory}");
        return str_replace('public/', '', $path);
    }
}
