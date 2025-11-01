<?php

namespace Ipr3\Tests;

use Ipr3\URLHelper;
use PHPUnit\Framework\TestCase;

class URLHelperTest extends TestCase
{
  public function testParseQueryStringWithValidUrls()
  {
    $result = URLHelper::parseQueryString('https://example.com?name=John');
    $this->assertEquals(['name' => 'John'], $result);

    $result = URLHelper::parseQueryString('https://example.com?name=John&age=30&city=London');
    $this->assertEquals([
      'name' => 'John',
      'age' => '30',
      'city' => 'London'
    ], $result);

    $result = URLHelper::parseQueryString('https://example.com');
    $this->assertEquals([], $result);
  }

  public function testParseQueryStringWithInvalidInput()
  {
    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('URL не может быть пустым');
    URLHelper::parseQueryString('');
  }

  public function testBuildQueryStringWithValidParams()
  {
    $result = URLHelper::buildQueryString(['name' => 'John']);
    $this->assertEquals('name=John', $result);

    $result = URLHelper::buildQueryString([
      'name' => 'John',
      'age' => 30,
      'city' => 'London'
    ]);
    $this->assertStringContainsString('name=John', $result);
    $this->assertStringContainsString('age=30', $result);
    $this->assertStringContainsString('city=London', $result);

    $result = URLHelper::buildQueryString([]);
    $this->assertEquals('', $result);
  }
}
