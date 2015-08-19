<?php
namespace Koklu\MasterData\Model\Adminhtml;

class Observer
{
    /**
     * Source with options "Yes" and "No"
     * @var \Magento\Config\Model\Config\Source\Yesno
     */
    protected $_yesNo;

    /**
     * Constructor
     * @param \Magento\Config\Model\Config\Source\Yesno $yesNo
     */
    public function __construct(\Magento\Config\Model\Config\Source\Yesno $yesNo)
    {
        $this->_yesNo = $yesNo;
    }

    /**
     * Adds 'used_in_recommender' form field
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function addUsedInRecommender(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $observer->getEvent()->getForm();

        $fieldset = $form->getElement('advanced_fieldset');
        $fieldset->addField(
            'used_in_recommender',
            'select',
            [
                'name' => 'used_in_recommender',
                'label' => __('Used in Recommender'),
                'title' => __('Used in Recommender (Exported to the recommender system)'),
                'note' => __('Exported to the recommender system'),
                'values' => $this->_yesNo->toOptionArray()
            ]
        );
    }
}