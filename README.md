# Magento2 Smart Category Configurable
SmartCategory functionality from Configurable products. Extension has a dependency on [Smart Category](https://github.com/karliuka/m2.SmartCategory) and not used individually.

### Category edit page
<img alt="Magento2 Smart Category" src="https://karliuka.github.io/m2/smart-category/rule.png" style="width:100%"/>

## Compatibility

Magento CE 2.1.x, 2.2.x, 2.3.x

## Install

Before installing, you must first install the module [Smart Category](https://github.com/karliuka/m2.SmartCategory).

#### Install via Composer (recommend)

Install the module [Smart Category](https://github.com/karliuka/m2.SmartCategory).  The corresponding version of the Smart Category Configurable will be installed automatically.

   
#### Manual Installation
   
1. Create a folder {Magento root}/app/code/Faonni/SmartCategoryConfigurable

2. Download the corresponding [latest version](https://github.com/karliuka/m2.SmartCategoryConfigurable/releases)

3. Copy the unzip content to the folder ({Magento root}/app/code/Faonni/SmartCategoryConfigurable)

### Completion of installation

1. Go to Magento2 root folder

2. Enter following commands:

    ```bash
	php bin/magento setup:upgrade
	php bin/magento setup:di:compile
	php bin/magento setup:static-content:deploy  (optional)
