<?php
namespace Koklu\Recommender\Block\Checkout\Cart;

class Similar extends \Koklu\Recommender\Block\Catalog\Product\ListAbstract
{
    /**
     * Constructor
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Model\Resource\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Magento\Rule\Model\Condition\Sql\Builder $sqlBuilder
     * @param \Magento\CatalogWidget\Model\Rule $rule
     * @param \Magento\Widget\Helper\Conditions $conditionsHelper
     * @param array $data
     * @param \Koklu\Recommender\Model\Recommender\Checkout\Cart\Similar $recommender
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
        \Koklu\Recommender\Model\Recommender\Checkout\Cart\Similar $recommender
    ) {
        parent::__construct(
            $context, $productCollectionFactory, $catalogProductVisibility, $httpContext,
            $sqlBuilder, $rule, $conditionsHelper, $data, $recommender
        );
    }
}