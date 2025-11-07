<?php
//ⓒ WEBsiting.kr 
function getYoutubeVideoId($url) {
    // URL 파싱
    $parsed_url = parse_url($url);

    if (!isset($parsed_url['host'])) {
        return false; // 유효하지 않은 URL
    }

    $host = $parsed_url['host'];
    $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    $query = isset($parsed_url['query']) ? $parsed_url['query'] : '';

    // 호스트 앞 www. 제거
    $host = preg_replace('/^www\./', '', strtolower($host));

    // youtu.be 단축 URL (롱폼 공유 링크)
    if ($host === 'youtu.be') {
        // path가 /9Ej0lNeJCWw 형태
        $video_id = ltrim($path, '/');
        return $video_id;
    }

    // youtube.com 도메인 관련 처리
    if ($host === 'youtube.com' || $host === 'm.youtube.com' || $host === 'youtube-nocookie.com') {
        $parts = explode('/', trim($path, '/'));

        // shorts 링크: /shorts/VIDEO_ID
        if (isset($parts[0]) && $parts[0] === 'shorts' && isset($parts[1])) {
            return $parts[1];
        }

        // live 링크: /live/VIDEO_ID
        if (isset($parts[0]) && $parts[0] === 'live' && isset($parts[1])) {
            return $parts[1];
        }

        // watch 링크: ?v=VIDEO_ID
        if ($parts[0] === 'watch' || $path === '/watch') {
            parse_str($query, $query_vars);
            if (isset($query_vars['v'])) {
                return $query_vars['v'];
            }
        }
    }

    // www.youtube.com 도메인 관련 처리 (일반 브라우저 링크)
    if ($host === 'youtube.com' || $host === 'www.youtube.com') {
        $parts = explode('/', trim($path, '/'));

        // shorts 링크
        if (isset($parts[0]) && $parts[0] === 'shorts' && isset($parts[1])) {
            return $parts[1];
        }

        // live 링크
        if (isset($parts[0]) && $parts[0] === 'live' && isset($parts[1])) {
            return $parts[1];
        }

        // watch 링크
        if ($parts[0] === 'watch' || $path === '/watch') {
            parse_str($query, $query_vars);
            if (isset($query_vars['v'])) {
                return $query_vars['v'];
            }
        }
    }

    // 어떤 경우에도 ID를 못 찾으면 false 반환
    return false;
}