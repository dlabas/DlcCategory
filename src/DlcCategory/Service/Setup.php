<?php
namespace DlcCategory\Service;

use DlcBase\Service\AbstractSetupService;
use Zend\Console\ColorInterface as Color;

class Setup extends AbstractSetupService
{
    /**
     *
     * @var NestedSetManager
     */
    protected $nestedSetManager;
    
    /**
     * Getter for $nestedSetManager
     *
     * @return \DoctrineExtensions\NestedSet\Manager $nestedSetManager
     */
    public function getNestedSetManager()
    {
        if (!$this->nestedSetManager instanceof NestedSetManager) {
            $this->setNestedSetManager($this->getServiceLocator()->get('dlccategory_nestedset_manager'));
        }
        return $this->nestedSetManager;
    }
    
    /**
     * Setter for $nestedSetManager
     *
     * @param  \DoctrineExtensions\NestedSet\Manager $nestedSetManager
     * @return Setup
     */
    public function setNestedSetManager($nestedSetManager)
    {
        $this->nestedSetManager = $nestedSetManager;
        return $this;
    }
    
    /**
     * Run the module setup
     *
     * This method will be called if the ZFTool setup modules command will be executed.
     */
    public function runSetup()
    {
        if ($this->getParams()->createSampleData) {
            $this->createSampleData();
        }
    }
    
    public function createSampleData()
    {
        $this->consoleWriteWithIndent('Creating sample categories...');
        
        $nestedSetManager = $this->getNestedSetManager();
        
        //Create images root node
        $rootCategory = new \DlcCategory\Entity\Category();
        $rootCategory->setName('example-root-category')
                     ->setTitle('Example Root Category')
                     ->setDescription('The Example Root Category is the root category for all sample data categories')
                     ->setThumbnail('/img/no_thumbnail.png');
        
        $rootNode = $nestedSetManager->createRoot($rootCategory);
        
        //Create first root node
        $child = new \DlcCategory\Entity\Category();
        $child->setName('example-child-category')
              ->setTitle('Example Child Category')
              ->setDescription('The Example Child Category is the a child category of the Example Root Category')
              ->setThumbnail('/img/no_thumbnail.png');
        
        $categoryNode = $rootNode->addChild($child);
        
        $this->consoleWriteLine('done!', Color::GREEN);
    }
}