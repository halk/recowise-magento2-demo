<?php

use Magento\Store\Model\StoreManager;

require __DIR__ . '/../../app/bootstrap.php';

$params = $_SERVER;
$params[StoreManager::PARAM_RUN_CODE] = 'admin';
$params[StoreManager::PARAM_RUN_TYPE] = 'store';

$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $params);

/** @var \Koklu\MasterData\App\Shell $app */
$app = $bootstrap->createApplication(
    'Koklu\MasterData\App\Shell', ['entryFileName' => basename(__FILE__)]
);
$bootstrap->run($app);