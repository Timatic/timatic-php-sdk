<?php

require_once __DIR__ . '/vendor/autoload.php';

use Timatic\SDK\Timatic;

// Initialize the Timatic SDK
$timatic = new Timatic();

// Example 1: Get all users
echo "Fetching users...\n";
$response = $timatic->user()->getUsers();
if ($response->successful()) {
    $users = $response->json();
    echo "Found " . count($users['data'] ?? []) . " users\n\n";
}

// Example 2: Get all customers
echo "Fetching customers...\n";
$response = $timatic->customer()->getCustomers();
if ($response->successful()) {
    $customers = $response->json();
    echo "Found " . count($customers['data'] ?? []) . " customers\n\n";
}

// Example 3: Get budgets
echo "Fetching budgets...\n";
$response = $timatic->budget()->getBudgets();
if ($response->successful()) {
    $budgets = $response->json();
    echo "Found " . count($budgets['data'] ?? []) . " budgets\n\n";
}

// Example 4: Get current user info
echo "Fetching current user info...\n";
$response = $timatic->me()->getMes();
if ($response->successful()) {
    $me = $response->json();
    echo "Current user: " . ($me['data']['name'] ?? 'Unknown') . "\n\n";
}

// Example 5: Create a new entry (commented out to prevent accidental execution)
/*
echo "Creating a new entry...\n";
$response = $timatic->entry()->postEntries([
    'user_id' => 1,
    'customer_id' => 1,
    'date' => date('Y-m-d'),
    'hours' => 2.5,
    'description' => 'Working on SDK integration',
]);

if ($response->successful()) {
    echo "Entry created successfully!\n";
    $entry = $response->json();
    var_dump($entry);
}
*/

echo "Examples completed!\n";
