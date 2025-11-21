Focus steeds op een enkele hoofdtaak. Als deze klaar is geef dan de gelegenheid om feedback te geven en de resultaten te committen. 


## Task 1: Use Fluent Filters in GET Collection Tests

**Goal:** Replace 80+ filter constructor parameters with fluent filter chain

**Changes:**
- Modify `JsonApiPestTestGenerator.php` to detect GET collection requests (Paginatable interface)
- Add `generateFilterChain()` method - creates 2-3 representative filter examples
- Update test stub to use: `$request = (new GetEntriesRequest())->filter('userId',
  'test-123')->filter('startedAt', '2025-01-01', Operator::GreaterThanOrEquals)`
- Add proper imports (Operator enum)
- Regenerate with `composer regenerate` and test with `composer test`

## Task 2: Replace Fixtures with Inline Mock Data

**Goal:** Remove fixture dependencies, use inline `MockResponse::make()`

**Changes:**
- Add `generateMockResponseBody()` method - creates JSON:API structure from endpoint schema
- Generate realistic test data based on property types
- Use `MockResponse::make(body: ['data' => [...]])` instead of `MockResponse::fixture()`
- Handle both single resource and collection responses
- Regenerate with `composer regenerate` and test with `composer test`

## Task 3: Validate DTO Hydration in GET Tests

**Goal:** Verify JSON:API responses properly populate DTOs

**Changes:**
- Add expectations after response: `expect($data['type'])->toBe('entries')`
- Validate `data.id`, `data.attributes` structure
- Check 2-3 key DTO properties are present with expected values
- Regenerate with `composer regenerate` and test with `composer test`

## Task 4: Validate JSON:API Request Bodies in POST/PATCH Tests

**Goal:** Verify DTOs serialize to proper JSON:API format

**Changes:**
- Create DTO instance with test data in test
- Pass DTO to POST/PATCH method
- Use `Saloon::assertSent(function ($request) { ... })` callback
- Validate `data.type`, `data.attributes` structure
- Check specific attribute values match DTO input
- Regenerate with `composer regenerate` and test with `composer test`


## TASK 5: Add params for filters in Resources

**Note:** Each task is independent and can be completed, tested, and committed separately.