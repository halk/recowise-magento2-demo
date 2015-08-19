<?php
namespace Koklu\MasterData\App;

use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\Console\Response;
use Magento\Framework\AppInterface;

class Shell implements AppInterface
{
    /**
     * Filename of the entry point script
     * @var string
     */
    protected $_entryFileName;

    /**
     * Shell factory
     * @var \Koklu\MasterData\Model\Shell\Factory
     */
    protected $_shellFactory;

    /**
     * Console response
     * @var \Magento\Framework\App\Console\Response
     */
    protected $_response;

    /**
     * Constructor
     * @param string $entryFileName
     * @param \Koklu\MasterData\Model\Shell\Factory $shellFactory
     * @param Response $response
     */
    public function __construct($entryFileName, \Koklu\MasterData\Model\ShellFactory $shellFactory, Response $response)
    {
        $this->_entryFileName = $entryFileName;
        $this->_shellFactory = $shellFactory;
        $this->_response = $response;
    }

    /**
     * Run application
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function launch()
    {
        $shell = $this->_shellFactory->create(['entryPoint' => $this->_entryFileName]);
        $shell->run();
        $this->_response->setCode(0);
        return $this->_response;
    }

    /**
     * {@inheritdoc}
     */
    public function catchException(Bootstrap $bootstrap, \Exception $exception)
    {
        return false;
    }
}
