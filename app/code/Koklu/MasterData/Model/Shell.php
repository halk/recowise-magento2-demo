<?php
namespace Koklu\MasterData\Model;

/**
 * Shell model, used to work with logs via command line
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Shell extends \Magento\Framework\App\AbstractShell
{
    /**
     * Command factory
     * @var \Koklu\MasterData\Model\Shell\Command\Factory
     */
    protected $_commandFactory;

    /**
     * Constructor
     * @param \Magento\Framework\Filesystem $filesystem
     * @param string $entryPoint
     * @param \Koklu\MasterData\Model\Shell\Command\Factory $commandFactory
     */
    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        $entryPoint,
        \Koklu\MasterData\Model\Shell\Command\Factory $commandFactory
    ) {
        parent::__construct($filesystem, $entryPoint);
        $this->_commandFactory = $commandFactory;
    }

    /**
     * Runs script
     *
     * @return $this
     */
    public function run()
    {
        if ($this->_showHelp()) {
            return $this;
        }

        if ($this->getArg('export')) {
            $this->_runExport();
        } else {
            echo $this->getUsageHelp();
        }

        return $this;
    }

    /**
     * Runs export command
     *
     * @return string
     */
    protected function _runExport()
    {
        $productIds = $this->getArg('productIds') ? explode(',', $this->getArg('productIds')) : [];

        $this->_commandFactory->createExportCommand()->execute($productIds);
    }

    /**
     * Retrieves usage help message
     *
     * @return string
     */
    public function getUsageHelp()
    {
        return <<<USAGE
Usage:  php -f {$this->_entryPoint} [options] export

  --productIds <ids> Limit export by comma-separated product IDs
  export             Export products to recommender system
  help               This help

USAGE;
    }
}
