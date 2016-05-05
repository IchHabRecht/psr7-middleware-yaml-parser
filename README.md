# Yaml parser middleware

PSR-7 Middleware that parses Yaml files to ServerRequest attribute.

This middleware parses Yaml files or strings. The result is stored in an own ServerRequest attribute for further usage.

## Installation

`composer require ichhabrecht/psr7-middleware-yaml-parser`

## Usage

In Slim 3:

```php
$app->add(new \IchHabRecht\Psr7MiddlewareYamlParser\YamlParser(__DIR__ . '/settings.yml'));

$app->get('/', function ($request, $response, $args) {
    $settings = $request->getAttribute('yaml');

    return $response;
});
```

**Change attribute name**

It is possible to adjust the ServerRequest attribute name to your own needs.

```php
$app->add(new \IchHabRecht\Psr7MiddlewareYamlParser\YamlParser(__DIR__ . '/settings.yml', 'settings'));

$app->get('/', function ($request, $response, $args) {
    $settings = $request->getAttribute('settings');

    return $response;
});
```
