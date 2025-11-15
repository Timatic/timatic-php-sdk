<?php

declare(strict_types=1);

namespace Timatic\SDK\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Timatic\SDK\Resource\Budget budget()
 * @method static \Timatic\SDK\Resource\Customer customer()
 * @method static \Timatic\SDK\Resource\User user()
 * @method static \Timatic\SDK\Resource\Team team()
 * @method static \Timatic\SDK\Resource\Entry entry()
 * @method static \Timatic\SDK\Resource\Incident incident()
 * @method static \Timatic\SDK\Resource\Change change()
 * @method static \Timatic\SDK\Resource\Overtime overtime()
 * @method static \Timatic\SDK\Resource\Event event()
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
