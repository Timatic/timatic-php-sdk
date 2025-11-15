#!/bin/bash

# Timatic PHP SDK Regeneration Script
# This script downloads the latest OpenAPI specification and regenerates the SDK

set -e

echo "🔄 Regenerating Timatic PHP SDK with JSON:API support..."
echo ""

# Run the custom generator
php generator/generate.php

# Update autoloader
echo ""
echo "📦 Updating autoloader..."
composer dump-autoload

echo ""
echo "✅ All done! SDK has been regenerated with JSON:API models."
