<?php

namespace Tests\Unit\App\Service;

use App\Exception\ImageDecodeException;
use App\Service\Base64DecodeRemoteImageService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Description of Base64DecodeRemoteImageServiceTest
 *
 * @package Tests\Unit\App\Service
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
final class Base64DecodeRemoteImageServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testExecuteThrowsExceptionWhenTheImageContentCannotBeRead(): void
    {
        $this->expectException(ImageDecodeException::class);
        $this->expectExceptionMessage(ImageDecodeException::byImageUrl('image-url')->getMessage());

        $clientMock = $this->createClientMock();
        $clientMock->shouldReceive('get')->once()->andThrow(Mockery::mock(ClientException::class));

        (new Base64DecodeRemoteImageService($clientMock))->execute('image-url');
    }

    public function testExecuteReturnsTheDecodedContentOfTheImage(): void
    {
        $contentMock = Mockery::mock(StreamInterface::class);
        $contentMock->shouldReceive('getContents')->once()->andReturn('content');

        $responseMock = $this->createResponseMock();
        $responseMock->shouldReceive('getBody')->once()->andReturn($contentMock);

        $clientMock = $this->createClientMock();
        $clientMock->shouldReceive('get')->once()->with('image-url')->andReturn($responseMock);

        $result = (new Base64DecodeRemoteImageService($clientMock))->execute('image-url');

        $this->assertIsString($result);
        $this->assertSame(sprintf('data:image/png;base64,%s', base64_encode('content')), $result);
    }

    /**
     * Creates and returns a client mock.
     *
     * @return MockInterface|ClientInterface
     */
    private function createClientMock(): MockInterface
    {
        return Mockery::mock(ClientInterface::class);
    }

    /**
     * Creates and returns a ResponseInterface mock.
     *
     * @return MockInterface|ResponseInterface
     */
    private function createResponseMock(): MockInterface
    {
        return Mockery::mock(ResponseInterface::class);
    }
}
