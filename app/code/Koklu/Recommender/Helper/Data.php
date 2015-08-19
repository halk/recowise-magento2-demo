<?php
namespace Koklu\Recommender\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Enabled config path
     */
    const XML_PATH_ENABLED = 'recommender/general/enabled';

    /**
     * API base URL config path
     */
    const XML_PATH_API_BASE_URL = 'recommender/api/base_url';

    /**
     * Returns if recommender module is enabled
     * @return string
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ENABLED);
    }

    /**
     * Returns base URL of recommender API
     * @return string
     */
    public function getApiBaseUrl()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_API_BASE_URL);
    }
}