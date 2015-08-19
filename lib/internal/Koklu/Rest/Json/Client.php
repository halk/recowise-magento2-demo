<?php
namespace Koklu\Rest\Json;

class Client extends \Zend_Rest_Client
{
    /**
     * Perform a POST or PUT
     *
     * Performs a POST or PUT request. Any data provided is set in the HTTP
     * client. String data is pushed in as raw POST data; array or object data
     * is pushed in as POST parameters.
     *
     * @param mixed $method
     * @param mixed $data
     * @return Zend_Http_Response
     */
    protected function _performPost($method, $data = null)
    {
        $client = self::getHttpClient();
        if (is_string($data)) {
            $client->setRawData($data, 'application/json');
        } elseif (is_array($data) || is_object($data)) {
            $client->setRawData(json_encode((array) $data), 'application/json');
        }
        return $client->request($method);
    }
}