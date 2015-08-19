<?php
namespace Koklu\MasterData\Helper\SampleData;

class Fixture extends \Magento\Tools\SampleData\Helper\Fixture
{
    /**
     * Gets path to fixture file, returns false if not found.
     * This implements a way to override core fixture files in this module
     *
     * @param string $subPath
     * @return string|bool
     */
    public function getPath($subPath)
    {
        return realpath(__DIR__ . '/../../fixtures/' . ltrim($subPath, '/'))
            ?: parent::getPath($subPath);
    }
}