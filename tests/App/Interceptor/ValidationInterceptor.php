<?php

declare(strict_types=1);

namespace Spiral\Tests\Writeaway\App\Interceptor;

use Spiral\Core\CoreInterceptorInterface;
use Spiral\Core\CoreInterface;
use Spiral\Filters\Exception\ValidationException;
use Spiral\Http\ResponseWrapper;

final class ValidationInterceptor implements CoreInterceptorInterface
{
    public function __construct(
        private readonly ResponseWrapper $responseWrapper
    ) {
    }

    public function process(string $controller, string $action, array $parameters, CoreInterface $core): mixed
    {
        try {
            return $core->callAction($controller, $action, $parameters);
        } catch (ValidationException $e) {
            return $this->responseWrapper->json(['errors' => $e->errors], 400);
        }
    }
}
