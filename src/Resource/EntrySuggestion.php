<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\EntrySuggestion\DeleteEntrySuggestionRequest;
use Timatic\SDK\Requests\EntrySuggestion\GetEntrySuggestionRequest;
use Timatic\SDK\Requests\EntrySuggestion\GetEntrySuggestionsRequest;

class EntrySuggestion extends BaseResource
{
    public function getEntrySuggestions(): Response
    {
        return $this->connector->send(new GetEntrySuggestionsRequest($filterdate, $filterdateeq, $filterdatenq, $filterdategt, $filterdatelt, $filterdategte, $filterdatelte, $filterdatecontains));
    }

    public function getEntrySuggestion(string $entrySuggestionId): Response
    {
        return $this->connector->send(new GetEntrySuggestionRequest($entrySuggestionId));
    }

    public function deleteEntrySuggestion(string $entrySuggestionId): Response
    {
        return $this->connector->send(new DeleteEntrySuggestionRequest($entrySuggestionId));
    }
}
