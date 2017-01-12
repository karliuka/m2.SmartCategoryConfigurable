<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     SmartCategoryConfigurable
 * @copyright   Copyright (c) 2017 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\SmartCategoryConfigurable\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\Config;

/**
 * Faonni_SmartCategory ConfigurableProductsProvider
 */
class ConfigurableProductsProvider
{
    /** 
     * @var \Magento\Framework\App\ResourceConnection 
     */
    private $_resource;
    
    /**
     * @var \Magento\Catalog\Model\Config
     */
    protected $_config;    

    /**
     * @var array
     */
    private $_productIds = [];
    
    /**
     * Catalog product visibility
     *
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_catalogProductVisibility;   
    
    /**
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility 
     * @param \Magento\Catalog\Model\Config $config
     */
    public function __construct(
		ResourceConnection $resource,
        Visibility $catalogProductVisibility,
        Config $config
	) {
        $this->_resource = $resource;
        $this->_catalogProductVisibility = $catalogProductVisibility;        
        $this->_config = $config;
    }

    /**
     * Retrieve parent products pairs ids
     * 
     * @param array $ids
     * @return array
     */
    public function getParentIds(array $ids)
    {
        $key = md5(json_encode($ids));
        
        if (!isset($this->_productIds[$key])) {
			
            $visibilityAttributeId = $this->_config->getAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'visibility'
            )->getId();			

            $connection = $this->_resource->getConnection();           
			$select = $connection
				->select()
				->from(['e' => $this->_resource->getTableName('catalog_product_entity')], ['e.entity_id'])
				->join(
					['l' => $this->_resource->getTableName('catalog_product_super_link')],
					'l.product_id=e.entity_id', 
					[]
				)  				                  
				->join(
					['p' => $this->_resource->getTableName('catalog_product_entity')],
					'l.parent_id=p.entity_id', 
					['parent_id' => new \Zend_Db_Expr('IF(i.value_id, p.entity_id, NULL)')]
				) 
				->joinLeft(
					['i' => $this->_resource->getTableName('catalog_product_entity_int')],
					'i.entity_id=p.entity_id AND i.store_id="0" AND i.attribute_id="' . $visibilityAttributeId . '" AND i.value IN(' . implode(',', $this->_catalogProductVisibility->getVisibleInSiteIds()) . ')', 
					[]
				) 				                       
				->where('p.type_id = ?', Configurable::TYPE_CODE)
				->where('e.entity_id IN (?)', $ids);            
            $this->_productIds[$key] = $connection->fetchPairs($select);
        }
        
        return $this->_productIds[$key];
    }
}
