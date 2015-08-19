<?php
namespace Koklu\Event\Model;

class Event extends \ArrayObject
{
    /**
     * Event subject
     * @var string
     */
    protected $_subject;

    /**
     * Constructor
     * @param string $subject
     * @param array $body
     */
    public function __construct($subject, $body = [])
    {
        $this->_subject = $subject;

        parent::__construct($body);
    }

    /**
     * Returns event subject
     * @return string
     */
    public function getSubject()
    {
        return $this->_subject;
    }

    /**
     * Returns event body
     * @return array
     */
    public function toArray()
    {
        return $this->getArrayCopy();
    }
}