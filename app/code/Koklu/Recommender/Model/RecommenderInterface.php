<?php
namespace Koklu\Recommender\Model;

interface RecommenderInterface
{
    /**
     * Get recommended IDs
     *
     * @return array
     */
    public function recommend();

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParameters();

    /**
     * Set parameters
     *
     * @param array $params params to add
     * @return array
     */
    public function setParameters(array $params = []);
}