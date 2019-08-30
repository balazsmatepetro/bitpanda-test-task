<?php

namespace Tests\Unit\App\Exception;

use App\Exception\ImageDecodeException;
use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * Description of ImageDecodeExceptionTest
 *
 * @package Tests\Unit\App\Exception
 * @author Balázs Máté Petró <petrobalazsmate@gmail.com>
 */
final class ImageDecodeExceptionTest extends TestCase
{
    /**
     * @var ImageDecodeException
     */
    private $instance;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->instance = ImageDecodeException::byImageUrl('image-url');
    }

    public function testByImageUrlCreatesExpectedInstance(): void
    {
        $this->assertInstanceOf(ImageDecodeException::class, $this->instance);
        $this->assertInstanceOf(Exception::class, $this->instance);
        $this->assertInstanceOf(Throwable::class, $this->instance);
    }

    public function testByImageUrlCreatesInstanceWithTheExpectedMessage(): void
    {
        $this->assertSame('The image \'image-url\' could not be decoded!', $this->instance->getMessage());
    }

    public function testByImageUrlCreatesInstanceWithTheDefaultCode(): void
    {
        $this->assertSame(0, $this->instance->getCode());
    }

    public function testByImageUrlCreatesInstanceWithNullPreviousException(): void
    {
        $this->assertNull($this->instance->getPrevious());
    }
}
