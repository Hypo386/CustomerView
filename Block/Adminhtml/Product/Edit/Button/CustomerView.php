<?php
/**
 * Copyright © Acesofspades. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aos\CustomerView\Block\Adminhtml\Product\Edit\Button;

use Aos\CustomerView\Block\Adminhtml\UrlBuilder;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic as CoreGeneric;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Aos\CustomerView\Block\Adminhtml\RewriteResolver;

/**
 * Class CustomerView
 *
 * @package Aos\Customerview\Block\Adminhtml\Product\Edit\Button
 */
class CustomerView extends CoreGeneric
{
    /**
     * @var UrlBuilder
     */
    protected $actionUrlBuilder;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var RewriteResolver
     */
    protected $rewriteResolver;

    /**
     * CustomerView constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     * @param UrlBuilder $actionUrlBuilder
     * @param RewriteResolver $rewriteResolver
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        UrlBuilder $actionUrlBuilder,
        RewriteResolver $rewriteResolver
    ) {
        $this->storeManager     = $storeManager;
        $this->actionUrlBuilder = $actionUrlBuilder;
        $this->rewriteResolver  = $rewriteResolver;

        parent::__construct($context, $registry);
    }

    /**
     * Get button data
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getButtonData()
    {
        $urls = $this->getCustomerViewUrls();

        $buttonData = [
            'label'      => __('Customer View'),
            'class'      => '',
            'on_click'   => !empty($urls) ? sprintf("window.open('%s', '_blank');", reset($urls)) : null,
            'class_name' => \Aos\CustomerView\Ui\Component\Control\SplitButton::class,
            'options'    => $this->getOptions(),

            'sort_order' => -10
        ];

        $product = $this->getProduct();
        if (!$product->isSalable() || !$product->getId() || empty($urls)) {
            $buttonData['disabled'] = 'disabled';
        }

        return $buttonData;
    }

    /**
     * Get options
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getOptions()
    {
        $options = [];

        $urls = $this->getCustomerViewUrls();

        if (!empty($urls)) {
            foreach ($urls as $rewrite => $url) {
                $options[] = [
                    'id_hard' => $rewrite,
                    'label'   => __($rewrite),
                    'onclick' => sprintf("window.open('%s', '_blank');", $url),
                ];
            }
        }

        return $options;
    }

    /**
     * Get customer view urls
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getCustomerViewUrls()
    {
        $url = [];

        /* @var \Magento\Store\Model\Store\Interceptor */
        $currentStore = $this->rewriteResolver->getStore();

        //pobierz urle do request_path
        $urlRewrites = $this->rewriteResolver->getUrlRewrites(
            $this->getProduct()->getId(),
            ProductUrlRewriteGenerator::ENTITY_TYPE
        );

        if (!empty($urlRewrites)) {
            foreach ($urlRewrites as $rewrite) {
                $url[$rewrite] = $this->actionUrlBuilder->getUrl(
                    $rewrite,
                    $currentStore
                );
            }
        }

        return $url;
    }
}
