<?php

use App\Models\Department;

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
        // Extract ID from Google Drive link
        preg_match('/\/file\/d\/([^\/]+)\//', $url, $matches);
        return isset($matches[1])
            ? 'https://drive.google.com/file/d/' . $matches[1] . '/preview'
            : $url;
    }

    return $url; // default return if unrecognized
}

// function videoThumbnail($url)
// {
//     // YouTube - https://img.youtube.com/vi/{id}/hqdefault.jpg
//     if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
//         preg_match('/(?:v=|\/)([0-9A-Za-z_-]{11})/', $url, $matches);
//         return isset($matches[1]) ? "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg" : null;
//     }

//     // Vimeo thumbnail requires API or oEmbed, so just return placeholder or null
//     if (strpos($url, 'vimeo.com') !== false) {
//         return asset('assets/images/video-placeholder.jpg'); // custom fallback
//     }

//     return null;
// }

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
        // Coba ambil thumbnail resolusi tinggi
        $maxres = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
        $hq = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";

        // Gunakan maxres jika tersedia, fallback ke hqdefault
        if (@getimagesize($maxres)) {
            return $maxres;
        } else {
            return $hq;
        }
    }

    return null;
}


// function toEmbedUrl($url)
// {
//     if (strpos($url, 'youtube.com/watch') !== false) {
//         parse_str(parse_url($url, PHP_URL_QUERY), $params);
//         $id = $params['v'] ?? null;
//         return [
//             'url' => 'https://www.youtube.com/watch?v=' . $id,
//             'embed' => 'https://www.youtube.com/embed/' . $id,
//             'embeddable' => true,
//             'source' => 'youtube'
//         ];
//     }

//     if (strpos($url, 'youtu.be/') !== false) {
//         $id = substr(parse_url($url, PHP_URL_PATH), 1);
//         return [
//             'url' => 'https://youtu.be/' . $id,
//             'embed' => 'https://www.youtube.com/embed/' . $id,
//             'embeddable' => true,
//             'source' => 'youtube'
//         ];
//     }

//     if (strpos($url, 'vimeo.com/') !== false) {
//         $id = basename(parse_url($url, PHP_URL_PATH));
//         return [
//             'url' => 'https://vimeo.com/' . $id,
//             'embed' => 'https://player.vimeo.com/video/' . $id,
//             'embeddable' => true,
//             'source' => 'vimeo'
//         ];
//     }

//     if (strpos($url, 'drive.google.com/file/d/') !== false) {
//         preg_match('/\/file\/d\/([^\/]+)\//', $url, $matches);
//         $id = $matches[1] ?? null;
//         return [
//             'url' => $url,
//             'embed' => 'https://drive.google.com/file/d/' . $id . '/preview',
//             'embeddable' => false,
//             'source' => 'google-drive'
//         ];
//     }

//     return [
//         'url' => $url,
//         'embed' => $url,
//         'embeddable' => false,
//         'source' => 'unknown'
//     ];
// }
