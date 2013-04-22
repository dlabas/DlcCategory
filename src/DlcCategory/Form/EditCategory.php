<?php
namespace DlcCategory\Form;

use DlcCategory\Form\BaseForm;
use DlcCategory\Service\Category as CategoryService;
use Zend\Form\FormInterface;

class EditCategory extends BaseForm
{
    public function init()
    {
        parent::init();
        
        $this->setLabel('Edit category');
    }
    
    public function bind($category, $flags = FormInterface::VALUES_NORMALIZED)
    {
        parent::bind($category, $flags);
        
        $node = $this->getServiceLocator()
                     ->get('dlccategory_category_service')
                     ->getNestedSetManager()
                     ->wrapNode($category);
        
        if ($node->isRoot()) {
            $insertionAs = CategoryService::ROOT_NODE;
            $insertionOf = '';
        } elseif ($node->hasNextSibling()) {
            $insertionAs = CategoryService::PREV_SIBILING_OF;
            $insertionOf = $node->getNextSibiling()->getNode()->getId();
        } elseif ($node->hasPrevSibling()) {
            $insertionAs = CategoryService::NEXT_SIBILING_OF;
            $insertionOf = $node->getPrivSibiling()->getNode()->getId();
        } elseif ($node->hasParent()) {
            $insertionAs = CategoryService::FIRST_CHILD_OF;
            $insertionOf = $node->getParent()->getNode()->getId();
        } else {
            $insertionAs = '';
            $insertionOf = '';
        }
        
        $this->byName['category']->get('insertion-method')->setValue($insertionAs);
        $this->byName['category']->get('insertion-point')->setValue($insertionOf);
    }
}