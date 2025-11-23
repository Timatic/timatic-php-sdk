<?php

namespace Timatic\SDK\Generator\TestGenerators\Traits;

trait MockJsonDataTrait
{
    /**
     * Format an array as PHP code string
     */
    protected function formatArrayAsPhp(array $data, int $indent = 0): string
    {
        $indentStr = str_repeat('    ', $indent);
        $lines = [];

        foreach ($data as $key => $value) {
            $keyStr = is_string($key) ? "'$key'" : $key;

            if (is_array($value)) {
                $lines[] = $indentStr."    $keyStr => ".$this->formatArrayAsPhp($value, $indent + 1).',';
            } elseif (is_string($value)) {
                $escapedValue = addslashes($value);
                $lines[] = $indentStr."    $keyStr => '$escapedValue',";
            } elseif (is_bool($value)) {
                $lines[] = $indentStr."    $keyStr => ".($value ? 'true' : 'false').',';
            } elseif (is_null($value)) {
                $lines[] = $indentStr."    $keyStr => null,";
            } else {
                $lines[] = $indentStr."    $keyStr => $value,";
            }
        }

        if (empty($lines)) {
            return '[]';
        }

        return "[\n".implode("\n", $lines)."\n$indentStr]";
    }
}
