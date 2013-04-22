<?php
namespace DlcCategory\Controller;

use DlcBase\Controller\AbstractActionController;
//use DlcCategory\Form\AddCategory as AddCategoryForm;
//use DlcCategory\Form\EditCategory as EditCategoryForm;
use DlcCategory\Service\Category AS CategoryService;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;

/**
 * The category controller
 */
class CategoryController extends AbstractActionController
{
    /**
     * 
     * @var CategoryService
     */
    protected $categoryService;
    
    /**
     * Getter for $categoryService
     *
     * @return CategoryService $categoryService
     */
    public function getCategoryService()
    {
        if (!$this->categoryService instanceof CategoryService) {
            $this->categoryService = $this->getServiceLocator()->get('dlccategory_category_service');
        }
        return $this->categoryService;
    }

	/**
     * Setter for $categoryService
     *
     * @param  CategoryService $categoryService
     * @return CategoryController
     */
    public function setCategoryService($categoryService)
    {
        $this->categoryService = $categoryService;
        return $this;
    }

	/**
     * Getter for $addCategoryForm
     *
     * @return \DlcCategory\Form\AddCategory $addCategoryForm
     */
    public function getAddCategoryForm()
    {
        return $this->getCategoryService()->getAddForm();
    }
    
    /**
     * Getter for $editCategoryForm
     *
     * @return \DlcCategory\Form\EditCategory $editCategoryForm
     */
    public function getEditCategoryForm()
    {
        return $this->getCategoryService()->getEditForm();
    }
    
    /**
     * Returns the prefix for the route identifier
     */
    public function getRouteIdentifierPrefix()
    {
        return $this->getOptions()->getRouteIdentifierPrefix();
    }

	/**
     * Returns the add category route identifier
     * 
     * @var string
     */
    public function getAddCategoryRoute()
    {
        return $this->getRouteIdentifierPrefix() . '/add';
    }
    
    /**
     * Returns the route for redirection after add category was successful
     *
     * @var string
     */
    public function getAddCategoryRedirectRoute()
    {
        return $this->getRouteIdentifierPrefix();
    }
    
    /**
     * Returns the edit category route identifier
     *
     * @var string
     */
    public function getEditCategoryRoute()
    {
        return $this->getRouteIdentifierPrefix() . '/edit';
    }
    
    /**
     * Returns the route for redirection after edit category was successful
     *
     * @var string
     */
    public function getEditCategoryRedirectRoute()
    {
        return $this->getRouteIdentifierPrefix();
    }
    
    /**
     * Returns the delete category route identifier
     *
     * @var string
     */
    public function getDeleteCategoryRoute()
    {
        return $this->getRouteIdentifierPrefix() . '/delete';
    }
    
    /**
     * Returns the route for redirection after delete category was successful
     *
     * @var string
     */
    public function getDeleteCategoryRedirectRoute()
    {
        return $this->getRouteIdentifierPrefix();
    }

	public function indexAction()
    {        
        $trees = $this->getCategoryService()->getAllCategoryTreesAsArray();
        
        return new ViewModel(array(
            'trees' => $trees
        ));
    }
    
    public function listAction()
    {
        return $this->redirect()->toRoute($this->getRouteIdentifierPrefix());
    }
    
    public function showAction()
    {
        $categoryId = $this->params()->fromRoute('id', null);
        
        return new ViewModel(array(
            'categoryBranch' => $this->getCategoryService()->getCategoryBranch($categoryId),
        ));
    }
    
    /**
     * 
     * @link http://framework.zend.com/manual/2.1/en/modules/zend.mvc.plugins.html#zend-mvc-controller-plugins-postredirectget
     *       Description of the prg() Plugin
     * 
     * @return \Zend\Stdlib\ResponseInterface|multitype:Ambigous <object, multitype:> boolean |multitype:Ambigous <NULL, \Zend\Stdlib\ResponseInterface> Ambigous <object, multitype:> |\Zend\Http\Response
     */
    public function addAction()
    {
        $request = $this->getRequest();
        $service = $this->getCategoryService();
        $form    = $this->getAddCategoryForm();
        
        if ($request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }
        
        $redirectUrl = $this->url()->fromRoute($this->getAddCategoryRoute()) . ($redirect ? '?redirect=' . $redirect : '');
        $prg = $this->prg($redirectUrl, true);
        
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'form'     => $form,
                'redirect' => $redirect,
            );
        }
        
        $post = $prg;
        $category = $service->create($post);
        
        $redirect = isset($prg['redirect']) ? $prg['redirect'] : null;
        
        if (!$category) {
            return array(
                'form'     => $form,
                'redirect' => $redirect,
            );
        }
        
        return $this->redirect()->toUrl($this->url()->fromRoute($this->getAddCategoryRedirectRoute()) . ($redirect ? '?redirect='.$redirect : ''));
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', null);
        
        $request  = $this->getRequest();
        $service  = $this->getCategoryService();
        $category = $service->getCategoryBranch($id)->getNode();
        $form     = $this->getEditCategoryForm();
        $form->bind($category);
        
        if ($request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }
        
        $redirectUrl = $this->url()->fromRoute($this->getEditCategoryRoute(), array('id' => $id)) . ($redirect ? '?redirect=' . $redirect : '');
        $prg = $this->prg($redirectUrl, true);
        
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'id'       => $id,
                'form'     => $form,
                'redirect' => $redirect,
            );
        }
        
        $post     = $prg;
        $category = $service->update($id, $post);
        
        $redirect = isset($prg['redirect']) ? $prg['redirect'] : null;
        
        if (!$category) {
            return array(
                'id' => $id,
                'form' => $form,
                'redirect' => $redirect,
            );
        }
        
        return $this->redirect()->toUrl($this->url()->fromRoute($this->getEditCategoryRedirectRoute()) . ($redirect ? '?redirect='.$redirect : ''));
    }
    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', null);
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $confirmed = $request->getPost('confirmed', false);
            if ($confirmed) {
                $id = (int) $request->getPost('id');
                
                $this->getCategoryService()->deleteCategory($id);
                
                return $this->redirect()->toRoute($this->getDeleteCategoryRedirectRoute());
            }
        }
        
        return new ViewModel(array(
            
        ));
    }
}
