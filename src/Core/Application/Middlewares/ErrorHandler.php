<?php

declare(strict_types=1);

namespace Troupe\TestlabApi\Core\Application\Middlewares;

use DomainException;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Throwable;

class ErrorHandler
{
    public function __invoke(Request $request, Response $response, callable $next): Response
    {
        try {
            $response = $next($request, $response);
        } catch (InvalidArgumentException $e) {
            $response = $response
                ->withStatus(400)
                ->withJson([
                    'type'       => 'InvalidParameter',
                    'message'    => $e->getMessage(),
                ]);
        } catch (DomainException $e) {
            $response = $response
                ->withStatus(409)
                ->withJson([
                    'type'       => 'BusinessLogic',
                    'message'    => $e->getMessage(),
                ]);
        } catch (Throwable $e) {
            $response = $response
                ->withStatus(500)
                ->withJson([
                    'type'        => 'internalError',
                    'message'     => 'Erro interno do servidor: ' . $e->getMessage(),
                ]);
        }

        return $response;
    }
}