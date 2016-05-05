<?php
namespace IchHabRecht\Psr7MiddlewareYamlParser;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Yaml\Parser;

class YamlParser
{
    /**
     * @var string
     */
    protected $attributeName = 'yaml';

    /**
     * @var string
     */
    protected $yamlFile;

    /**
     * @var Parser
     */
    protected $yamlParser;

    /**
     * @param string $yamlFile
     * @param string $attributeName
     * @param Parser|null $yamlParser
     */
    public function __construct($yamlFile, $attributeName = null, Parser $yamlParser = null)
    {
        $this->yamlFile = $yamlFile;
        if ($attributeName) {
            $this->attributeName = $attributeName;
        }
        $this->yamlParser = $yamlParser ?: new Parser();
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $yaml = $this->yamlParser->parse(file_get_contents($this->yamlFile));

        $request = $request->withAttribute($this->attributeName, $yaml);

        return $next($request, $response);
    }

}
