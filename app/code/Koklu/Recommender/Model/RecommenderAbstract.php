<?php
namespace Koklu\Recommender\Model;

abstract class RecommenderAbstract implements RecommenderInterface
{
    /**
     * Type of recommender (see recommender configuration)
     */
    const TYPE = '';

    /**
     * Registry
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * Client instance
     * @var Client
     */
    protected $_client;

    /**
     * User helper
     * @var \Koklu\Event\Helper\User
     */
    protected $_userHelper;

    /**
     * Recommended items
     * @var array
     */
    protected $_results;

    /**
     * Parameters
     * @var array
     */
    protected $_parameters = [];

    /**
     * Constructor
     *
     * @param \Magento\Framework\Registry $registry
     * @param Client $client
     * @param \Koklu\Event\Helper\User $userHelper
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        Client $client,
        \Koklu\Event\Helper\User $userHelper
    ) {
        $this->_registry = $registry;
        $this->_client = $client;
        $this->_userHelper = $userHelper;
    }

    /**
     * Get recommended IDs
     *
     * @return array
     */
    public function recommend()
    {
        $this->_results = $this->_client->getRecommendations(static::TYPE, $this->getParameters());
        return $this->_results;
    }

    /**
     * Get parameters
     *
     * @param array $params params to add
     * @return RecommenderAbstract
     */
    public function setParameters(array $params = [])
    {
        $this->_parameters = array_merge(['user_id' => $this->_userHelper->getUserId()], $params);
        return $this;
    }

    /**
     * Return parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->_parameters;
    }

    /**
     * Returns result set
     *
     * @return array
     */
    public function getResults()
    {
        return $this->_results;
    }
}