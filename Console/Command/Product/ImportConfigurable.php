<?php
/**
 * Copyright © 2016 FireGento e.V. - All rights reserved.
 * See LICENSE.md bundled with this module for license details.
 */
namespace FireGento\FastSimpleImportDemo\Console\Command\Product;

use FireGento\FastSimpleImportDemo\Console\Command\AbstractImportCommand;
use Magento\ImportExport\Model\Import;

/**
 * Class TestCommand
 * @package FireGento\FastSimpleImport2\Console\Command
 *
 */
class ImportConfigurable extends AbstractImportCommand
{


    protected function configure()
    {
        $this->setName('fastsimpleimportdemo:products:importconfigurable')
            ->setDescription('Import Configurable Products ');

        $this->setBehavior(Import::BEHAVIOR_APPEND);
        $this->setEntityCode('catalog_product');

        parent::configure();
    }

    /**
     * @return array
     */
    protected function getEntities()
    {
        $simpleProducts = [];
        $configurableProduct = array(
            'sku' => 'CONFIG-Product',
            'attribute_set_code' => 'Default',
            'product_type' => 'configurable',
            'product_websites' => 'base',
            'name' => 'FireGento Test Product Configurable',
            'price' => '10.000',
            'configurable_variation_labels' => 'Color'

        );

        $colors = array("blue", "black");
        $variationsString = '';
        for ($i = 0; $i < 2; $i++) {

            $color = $colors[$i];
            $sku = 'SIMPLE-' . $color;
            $simpleProducts[] = array(
                'sku' => $sku,
                'attribute_set_code' => 'Default',
                'product_type' => 'simple',
                'product_websites' => 'base',
                'name' => 'FireGento Test Product Simple - ' . $color,
                'price' => '14.0000',
                'additional_attributes' => array('color' => $color)

            );
            $variationsString[] = array('sku' => $sku, 'color' => $color);
        }
        $configurableProduct["configurable_variations"] = $variationsString;


        $data = array_merge($simpleProducts, array($configurableProduct));


        return $data;
    }
}