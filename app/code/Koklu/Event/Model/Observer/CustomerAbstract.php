<?php
namespace Koklu\Event\Model\Observer;

abstract class CustomerAbstract extends ObserverAbstract
{
    /**
     * User Helper
     * @var \Koklu\Event\Helper\User
     */
    protected $_userHelper;

    /**
     * Constructor
     * @param \Koklu\Recommender\Model\Client $client
     * @param \Koklu\Event\Helper\User $userHelper
     */
    public function __construct(
        \Koklu\Recommender\Model\Client $client,
        \Koklu\Event\Helper\User $userHelper
    ) {
        parent::__construct($client);
        $this->_userHelper = $userHelper;
    }
}