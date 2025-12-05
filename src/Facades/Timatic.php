<?php

declare(strict_types=1);

namespace Timatic\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Saloon\Http\Response send(\Saloon\Http\Request $request)
 * @method static \Timatic\TimaticConnector withMockClient(\Saloon\Http\Faking\MockClient $mockClient)
 * @method static \Timatic\TimaticConnector headers()
 * @method static \Timatic\TimaticConnector baseUrl(string $url)
 *
 * @see \Timatic\TimaticConnector
 */
class Timatic extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \Timatic\TimaticConnector::class;
    }
}
