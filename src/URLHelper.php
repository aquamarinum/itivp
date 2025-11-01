<?php

namespace Ipr3;

class URLHelper
{
  public static function parseQueryString(string $url): array
  {
    if (empty($url)) {
      throw new \InvalidArgumentException('URL не может быть пустым');
    }

    $queryString = parse_url($url, PHP_URL_QUERY);

    if (empty($queryString)) {
      return [];
    }

    $result = [];
    parse_str($queryString, $result);

    return $result;
  }

  public static function buildQueryString(array $params): string
  {
    if (empty($params)) {
      return '';
    }

    return http_build_query($params);
  }
}
