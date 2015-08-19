<?php
namespace Koklu\MasterData\Model\Shell\Command;

class Factory
{
    /**
     * Object manager
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * Constructor
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->_objectManager = $objectManager;
    }

    /**
     * Create export command
     *
     * @return \Koklu\MasterData\Model\Shell\CommandInterface
     */
    public function createExportCommand()
    {
        return $this->_objectManager->create('Koklu\MasterData\Model\Shell\Command\Export');
    }
}
