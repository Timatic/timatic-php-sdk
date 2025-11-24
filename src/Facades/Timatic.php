<?php

declare(strict_types=1);

namespace Timatic\SDK\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Saloon\Http\Response send(\Saloon\Http\Request $request)
 * @method static \Timatic\SDK\TimaticConnector withMockClient(\Saloon\Http\Faking\MockClient $mockClient)
 * @method static \Timatic\SDK\TimaticConnector headers()
 * @method static \Timatic\SDK\TimaticConnector baseUrl(string $url)
 *
 * @see \Timatic\SDK\TimaticConnector
 */
class Timatic extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \Timatic\SDK\TimaticConnector::class;
    }
}
