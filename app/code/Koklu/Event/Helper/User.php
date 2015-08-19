<?php
namespace Koklu\Event\Helper;

class User
{
    /**
     * Customer session
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * Customer Visitor
     * @var \Magento\Customer\Model\Visitor
     */
    protected $_customerVisitor;

    /**
     * Constructor
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Visitor $customerVisitor
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Visitor $customerVisitor
    ) {
        $this->_customerSession = $customerSession;
        $this->_customerVisitor = $customerVisitor;
    }

    /**
     * Returns user ID. If it is not a customer, a hash of the visitor ID is generated with md5
     * to differentiate from a customer ID
     * @return string|int
     */
    public function getUserId()
    {
        if ($this->isUserLoggedIn()) {
            return $this->_customerSession->getCustomerId();
        }

        return $this->getUserIdByVisitor();
    }

    /**
     * Generates user ID from Magento's visitor model
     * @return string
     */
    public function getUserIdByVisitor()
    {
        return md5($this->_customerVisitor->getId());
    }

    /**
     * Returns true if user is logged in
     * @return bool
     */
    public function isUserLoggedIn()
    {
        return $this->_customerSession->isLoggedIn();
    }
}