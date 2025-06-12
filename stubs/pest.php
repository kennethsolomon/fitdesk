<?php

declare(strict_types=1);

namespace Pest\Laravel {

    /**
     * Sets the currently logged-in user for the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable&\Illuminate\Database\Eloquent\Model  $user
     * @param  string|null  $driver
     * @return \Illuminate\Foundation\Testing\TestCase|\Tests\TestCase
     *
     * @phpstan-param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @psalm-param \Illuminate\Contracts\Auth\Authenticatable $user
     */
    function actingAs(): \Illuminate\Foundation\Testing\TestCase
    {
        // Stub implementation
        return new \Illuminate\Foundation\Testing\TestCase();
    }

    /**
     * Visit the given URI with a GET request.
     *
     * @param  array<string, mixed>  $headers
     */
    function get(string $uri, array $headers = []): \Illuminate\Testing\TestResponse
    {
        // Stub implementation
        return new \Illuminate\Testing\TestResponse(new \Illuminate\Http\Response());
    }

    /**
     * Visit the given URI with a POST request.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $headers
     */
    function post(string $uri, array $data = [], array $headers = []): \Illuminate\Testing\TestResponse
    {
        // Stub implementation
        return new \Illuminate\Testing\TestResponse(new \Illuminate\Http\Response());
    }

    /**
     * Visit the given URI with a PUT request.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $headers
     */
    function put(string $uri, array $data = [], array $headers = []): \Illuminate\Testing\TestResponse
    {
        // Stub implementation
        return new \Illuminate\Testing\TestResponse(new \Illuminate\Http\Response());
    }

    /**
     * Visit the given URI with a PATCH request.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $headers
     */
    function patch(string $uri, array $data = [], array $headers = []): \Illuminate\Testing\TestResponse
    {
        // Stub implementation
        return new \Illuminate\Testing\TestResponse(new \Illuminate\Http\Response());
    }

    /**
     * Visit the given URI with a DELETE request.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $headers
     */
    function delete(string $uri, array $data = [], array $headers = []): \Illuminate\Testing\TestResponse
    {
        // Stub implementation
        return new \Illuminate\Testing\TestResponse(new \Illuminate\Http\Response());
    }
}
