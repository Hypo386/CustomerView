<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\CustomerView\Block\Adminhtml;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Store;

/**
 * Adminhtml catalog product action customer view
 */
class UrlBuilder
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $frontendUrlBuilder;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * UrlBuilder constructor.
     *
     * @param \Magento\Framework\UrlInterface $frontendUrlBuilder
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\UrlInterface $frontendUrlBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->frontendUrlBuilder = $frontendUrlBuilder;
        $this->scopeConfig        = $scopeConfig;
    }

    /**
     * Get action url
     *
     * @param string $routePath
     * @param \Magento\Store\Model\Store\Interceptor $store
     *
     * @return string
     */
    public function getUrl($routePath, $store)
    {
        $this->frontendUrlBuilder->setScope($store->getStoreId());

        $storeInUrl = $this->scopeConfig->getValue(
            Store::XML_PATH_STORE_IN_URL,
            StoreManagerInterface::CONTEXT_STORE,
            $store
        );

        return $this->frontendUrlBuilder->getUrl(
            '',
            [
                '_direct' => $routePath,
                '_nosid'  => true,
                '_query'  => !$storeInUrl ? [StoreManagerInterface::PARAM_NAME => $store->getCode()] : null
            ]
        );
    }
}
