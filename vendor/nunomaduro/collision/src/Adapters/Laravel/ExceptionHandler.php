<?php

/**
 * This file is part of Collision.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace NunoMaduro\Collision\Adapters\Laravel;

use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use NunoMaduro\Collision\Contracts\Provider as ProviderContract;
use Symfony\Component\Console\Exception\ExceptionInterface as SymfonyConsoleExceptionInterface;

/**
 * This is an Collision Laravel Adapter ExceptionHandler implementation.
 *
 * Registers the Error Handler on Laravel.
 *
 * @author Nuno Maduro <enunomaduro@gmail.com>
 */
class ExceptionHandler implements ExceptionHandlerContract
{
    /**
     * Holds an instance of the application exception handler.
     *
     * @var \Illuminate\Contracts\Debug\ExceptionHandler
     */
    protected $appExceptionHandler;

    /**
     * Holds an instance of the container.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * Creates a new instance of the ExceptionHandler.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Illuminate\Contracts\Debug\ExceptionHandler $appExceptionHandler
     */
    public function __construct(Container $container, ExceptionHandlerContract $appExceptionHandler)
    {
        $this->container = $container;
        $this->appExceptionHandler = $appExceptionHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function report(Exception $e)
    {
        $this->appExceptionHandler->report($e);
    }

    /**
     * {@inheritdoc}
     */
    public function render($request, Exception $e)
    {
        return $this->appExceptionHandler->render($request, $e);
    }

    /**
     * {@inheritdoc}
     */
    public function renderForConsole($output, Exception $e)
    {
        if ($e instanceof SymfonyConsoleExceptionInterface) {
            $this->appExceptionHandler->renderForConsole($output, $e);
        } else {
            $handler = $this->container->make(ProviderContract::class)
                ->register()
                ->getHandler()
                ->setOutput($output);

            $handler->setInspector((new Inspector($e)));

            $handler->handle();
        }
    }

    /**
     * Determine if the exception should be reported.
     *
     * @param \Exception $e
     * @return bool
     */
    public function shouldReport(Exception $e)
    {
        return $this->appExceptionHandler->shouldReport($e);
    }
}
