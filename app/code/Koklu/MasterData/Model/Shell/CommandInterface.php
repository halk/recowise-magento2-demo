<?php
namespace Koklu\MasterData\Model\Shell;

interface CommandInterface
{
    /**
     * Execute command
     *
     * @param array $productIds
     * @return string
     */
    public function execute($productIds = []);
}
