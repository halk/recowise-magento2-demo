<?php
namespace Koklu\MasterData\Block\Adminhtml\Catalog\Product\Attribute;

class Grid extends \Magento\Catalog\Block\Adminhtml\Product\Attribute\Grid
{
    /**
     * Prepare product attributes grid columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        $this->addColumnAfter(
            'is_used_in_recommender',
            [
                'header' => __('Use In Recommender'),
                'sortable' => true,
                'index' => 'used_in_recommender',
                'type' => 'options',
                'options' => ['1' => __('Yes'), '0' => __('No')],
                'align' => 'center'
            ],
            'is_comparable'
        );
        $this->removeColumn('is_comparable');

        return $this;
    }
}