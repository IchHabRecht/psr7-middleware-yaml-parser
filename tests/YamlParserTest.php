<?php
namespace IchHabRecht\Psr7MiddlewareYamlParser\Tests;

use IchHabRecht\Psr7MiddlewareYamlParser\YamlParser;
use org\bovigo\vfs\vfsStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class YamlParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $yamlInput = 'foo: bar';

    /**
     * @var array
     */
    protected $yamlOuput = [
        'foo' => 'bar',

    ];

    /**
     * @var string
     */
    protected $yamlFilePath;

    protected function setUp()
    {
        parent::setUp();

        vfsStream::setup('Test');
        $this->yamlFilePath = vfsStream::url('Test/file.yml');
        file_put_contents($this->yamlFilePath, $this->yamlInput);
    }

    public function testAttributeIsSet()
    {
        $middleware = new YamlParser($this->yamlFilePath);

        /** @var ServerRequestInterface|\Prophecy\Prophecy\ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        $request->withAttribute('yaml', $this->yamlOuput)->willReturn($request->reveal())->shouldBeCalled();
        $request->getAttribute('yaml')->shouldBeCalled();

        /** @var ResponseInterface|\Prophecy\Prophecy\ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class);

        $yaml = null;
        $request = $middleware(
            $request->reveal(),
            $response->reveal(),
            function (ServerRequestInterface $request, ResponseInterface $response) {
                $yaml = $request->getAttribute('yaml');

                return $response;
            }
        );
    }

    public function testAttributeNameCanBeGiven()
    {
        $middleware = new YamlParser($this->yamlFilePath, 'settings');

        /** @var ServerRequestInterface|\Prophecy\Prophecy\ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        $request->withAttribute('settings', $this->yamlOuput)->willReturn($request->reveal())->shouldBeCalled();
        $request->getAttribute('settings')->shouldBeCalled();

        /** @var ResponseInterface|\Prophecy\Prophecy\ObjectProphecy $response */
        $response = $this->prophesize(ResponseInterface::class);

        $yaml = null;
        $request = $middleware(
            $request->reveal(),
            $response->reveal(),
            function (ServerRequestInterface $request, ResponseInterface $response) {
                $yaml = $request->getAttribute('settings');

                return $response;
            }
        );
    }
}
