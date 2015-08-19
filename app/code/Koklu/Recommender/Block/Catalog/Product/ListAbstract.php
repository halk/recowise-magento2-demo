<?php
namespace Koklu\Recommender\Block\Catalog\Product;

abstract class ListAbstract extends \Magento\CatalogWidget\Block\Product\ProductsList
{
    const CACHE_KEY = 'recommender_product_list';

    /**
     * Recommender instance
     * @var \Koklu\Recommender\Model\RecommenderInterface
     */
    protected $_recommender;

    /**
     * Recommended SKUs Cache
     * @var array
     */
    protected $_recommendedSkus;

    /**
     * Constructor
     *
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Model\Resource\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Magento\Rule\Model\Condition\Sql\Builder $sqlBuilder
     * @param \Magento\CatalogWidget\Model\Rule $rule
     * @param \Magento\Widget\Helper\Conditions $conditionsHelper
     * @param array $data
     * @param \Koklu\Recommender\Model\RecommenderInterface $recommender
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\Resource\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Rule\Model\Condition\Sql\Builder $sqlBuilder,
        \Magento\CatalogWidget\Model\Rule $rule,
        \Magento\Widget\Helper\Conditions $conditionsHelper,
        array $data = [],
        \Koklu\Recommender\Model\RecommenderInterface $recommender
    ) {
        parent::__construct(
            $context, $productCollectionFactory, $catalogProductVisibility, $httpContext,
            $sqlBuilder, $rule, $conditionsHelper, $data
        );
        $this->_recommender = $recommender;
    }

    /**
     * Initialize
     *
     * @return void
     */
    protected function _construct()
    {
        // workaround for core bug which cannot find template for overridden block classes
        $this->setData('module_name', 'Magento_CatalogWidget');
        parent::_construct();
    }

    /**
     * Prepare and return product collection
     *
     * @return \Magento\Catalog\Model\Resource\Product\Collection
     */
    public function createCollection()
    {
        return parent::createCollection()
            ->addAttributeToFilter('sku', ['in' => $this->getRecommendedSkus()])
            ->setPageSize($this->getProductsCount());
    }

    /**
     * Returns recommender
     *
     * @return \Koklu\Recommender\Model\RecommenderInterface
     */
    public function getRecommender()
    {
        return $this->_recommender;
    }

    /**
     * Get recommended SKUs
     *
     * @return array
     */
    public function getRecommendedSkus()
    {
        if ($this->_recommendedSkus === null) {
            $this->_recommendedSkus = $this->getRecommender()
                ->setParameters($this->getParameters())
                ->recommend();
        }
        return $this->_recommendedSkus;
    }

    /**
     * Returns parameters for recommender
     *
     * @return array
     */
    public function getParameters()
    {
        return ['limit' => $this->getProductsCount()];
    }

    /**
     * Get key pieces for caching block content, add recommender parameters (such as user ID)
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array_merge(
            [
                static::CACHE_KEY,
                $this->_storeManager->getStore()->getId(),
                $this->_design->getDesignTheme()->getId(),
            ],
            $this->_flattenTwoDimensionalArray($this->getRecommender()->getParameters())
        );
    }

    /**
     * Cache for a minute (personalised blocks are subject to change quickly based on behaviour)
     *
     * @return int
     */
    public function getCacheLifetime()
    {
        return 60;
    }

    /**
     * Flattens two dimensional array so that it is accepted by getCacheKeyInfo
     *
     * @param array $array
     * @return array
     */
    protected function _flattenTwoDimensionalArray(array $array)
    {
        return array_map(function ($value) {
            if (is_array($value)) {
                return implode('|', $value);
            }
            return $value;
        }, $array);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->getRecommendedSkus() && !empty($this->getRecommendedSkus())) {
            return parent::_toHtml();
        }
    }

}