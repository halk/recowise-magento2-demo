<?php
namespace Koklu\MasterData\Model\Shell\Command;

use Koklu\Event\Model\Event;
use Koklu\MasterData\Model\Observer\Catalog\Product\Save;

class Export implements \Koklu\MasterData\Model\Shell\CommandInterface
{
    const CHUNK_SIZE = 25;

    /**
     * Client
     * @var \Koklu\Recommender\Model\Client
     */
    protected $_client;
    /**
     * Product resource
     * @var \Koklu\MasterData\Model\Resource\Catalog\Product
     */
    protected $_productResource;
    /**
     * Product builder
     * @var \Koklu\MasterData\Model\Catalog\Product\Builder
     */
    protected $_productBuilder;

    /**
     * Constructor
     * @param \Koklu\Recommender\Model\Client $client
     * @param \Koklu\MasterData\Model\Resource\Catalog\Product $productResource
     * @param \Koklu\MasterData\Model\Catalog\Product\Builder $productBuilder
     */
    public function __construct(
        \Koklu\Recommender\Model\Client $client,
        \Koklu\MasterData\Model\Resource\Catalog\Product $productResource,
        \Koklu\MasterData\Model\Catalog\Product\Builder $productBuilder
    ) {
        $this->_client = $client;
        $this->_productResource = $productResource;
        $this->_productBuilder = $productBuilder;
    }

    /**
     * Execute command
     *
     * @param array $productIds
     * @return void
     */
    public function execute($productIds = [])
    {
        $collection = $this->_productResource->getProducts($productIds, self::CHUNK_SIZE);

        $this->out(
            'Preparing export of %d products to recommender system...', [$collection->getSize()]
        );

        $curPage = $collection->getCurPage();
        while ($curPage <= $collection->getLastPageNumber()) {
            foreach ($collection as $product) {
                $this->_client->postEvent(new Event(
                    Save::EVENT_SUBJECT, $this->_productBuilder->create($product)
                ));
            }
            $this->out('%d of %d chunks exported...', [$curPage, $collection->getLastPageNumber()]);
            $collection->setCurPage(++$curPage);
        }

        $this->out('%d products exported to recommender', [$collection->getSize()]);
    }

    /**
     * Prints status information
     *
     * @param string $pattern
     * @param array  $arguments
     * @return void
     */
    protected function out($pattern, $arguments = [])
    {
        vprintf($pattern . PHP_EOL, $arguments);
    }
}
