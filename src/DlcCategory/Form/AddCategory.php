<?php
namespace DlcCategory\Form;

use DlcCategory\Form\BaseForm;

class AddCategory extends BaseForm
{
    public function init()
    {
        parent::init();
        
        $this->setLabel('Add new category');
        
        $this->byName['category']->remove('id');
    }
}