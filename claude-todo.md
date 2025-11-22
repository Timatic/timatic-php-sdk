Focus steeds op een enkele hoofdtaak. Als deze klaar is geef dan de gelegenheid om feedback te geven en de resultaten te committen.

## Task 3: Validate DTO Hydration in GET Tests

**Goal:** Verify JSON:API responses properly populate DTOs

**Changes:**
- Add expectations after response: `expect($data['type'])->toBe('entries')`
- Validate `data.id`, `data.attributes` structure
- Check 2-3 key DTO properties are present with expected values
- Regenerate with `composer regenerate` and test with `composer test`

## TASK: replace "type: resource" with actual resource in mocked GET data

## TASK 5: Add params for filters in Resources

- Make a plan how we can add filters like $timaticConnector->budget->getBudgets(['key'=>'value']);
- or come up with a better way to add filters to resources

## Gebruik raw JSON alleen om operationId → schema reference mapping te vinden (totdat we vendor package kunnen patchen)

**Note:** Each task is independent and can be completed, tested, and committed separately.