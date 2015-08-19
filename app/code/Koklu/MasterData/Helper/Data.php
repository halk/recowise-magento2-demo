<?php
namespace Koklu\MasterData\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * "System attributes to use in recommender" config path
     */
    const XML_PATH_SYSTEM_ATTRIBUTES = 'masterData/systemAttributesToUse';

    /**
     * Returns codes of system attributes to be used in recommender
     * @return array
     */
    public function getSystemAttributesToUseInRecommender()
    {
        return $this->getCommaSeparatedSystemConfig(self::XML_PATH_SYSTEM_ATTRIBUTES);
    }

    /**
     * @param string $path
     * @return array
     */
    protected function getCommaSeparatedSystemConfig($path)
    {
        return explode(',', $this->scopeConfig->getValue($path));
    }
}