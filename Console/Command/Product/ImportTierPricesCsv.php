<?php

namespace FireGento\FastSimpleImportDemo\Console\Command\Product;

use FireGento\FastSimpleImportDemo\Console\Command\AbstractImportCommand;
use Magento\AdvancedPricingImportExport\Model\Import\AdvancedPricing;
use Magento\Backend\App\Area\FrontNameResolver;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ObjectManagerFactory;
use Magento\ImportExport\Model\Import;
use League\Csv\Reader;
use League\Csv\Statement;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportTierPricesCsv extends AbstractImportCommand
{
    const IMPORT_FILE = "var/import/tier_prices.csv";

    /**
     * @var \Magento\Framework\Filesystem\Directory\ReadFactory
     */
    private $readFactory;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * Constructor
     */
    public function __construct(
        ObjectManagerFactory $objectManagerFactory,
        \Magento\Framework\Filesystem\Directory\ReadFactory $readFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directory_list
    )
    {
        parent::__construct($objectManagerFactory);
        $this->readFactory = $readFactory;
        $this->directoryList = $directory_list;
    }

    protected function configure()
    {
        $this->setName('fastsimpleimportdemo:products:import-tier-prices-csv')
            ->setDescription('Import Tier Prices from CSV');

        $this->setBehavior(Import::BEHAVIOR_REPLACE);
        $this->setEntityCode('advanced_pricing');

        parent::configure();
    }

    /**
     * @return array
     */
    protected function getEntities()
    {
        $csvIterationObject = $this->readCSV();
        $data = array();
        foreach ($csvIterationObject as $row) {
            $data[] = $row;
        }
        return $data;
    }

    protected function readCSV()
    {
        $csvObj = Reader::createFromString($this->readFile(static::IMPORT_FILE));
        $csvObj->setDelimiter(',');
        $csvObj->setHeaderOffset(0);
        return (new Statement())->process($csvObj);

    }

    protected function readFile($fileName)
    {
        $path = $this->directoryList->getRoot();
        $directoryRead = $this->readFactory->create($path);
        return $directoryRead->readFile($fileName);
    }
}
