Focus steeds op een enkele hoofdtaak. Als deze klaar is geef dan de gelegenheid om feedback te geven en de resultaten te committen.

## Task: apply Hydration for Requests

- Add `protected $model = Budget::class;` to the BudgetClass for example
- All GET, POST, PATCH request need to implement createDtoFromResponse
```
function createDtoFromResponse(Response $response): mixed
    {
        return Hydrator::hydrateCollection(
            $this->model,
            $response->json('data'),
            $response->json('included')
        );
    }
```

## Task 3: Validate DTO Hydration in GET Tests

**Goal:** Verify JSON:API responses properly populate DTOs

Test the fields that are set in the json to be present on the DTO.
```
    $dtoCollection = $response->dto();

    expect($dtoCollection->first())
        ->budgetTypeId->toBe("budget-type-xyz")
        ->customerId->toBe("customer-abc")
        ->showToCustomer->toBe(true)
        ->startedAt->toEqual(new Carbon("2025-11-22T10:40:04.065Z"))
```

**Changes:**
- Add expectations after response: `expect($data['type'])->toBe('entries')`
- Check DTO properties are present with expected values
- Regenerate with `composer regenerate` and test with `composer test`

## TASK: fix the test that have 

## TASK: Remove Me Request, Me Resource and Me Test

## TASK: replace "type: resource" with actual resource in mocked GET data

## Gebruik raw JSON alleen om operationId → schema reference mapping te vinden (totdat we vendor package kunnen patchen)

**Note:** Each task is independent and can be completed, tested, and committed separately.