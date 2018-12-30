<?php

class Fox_News_Adminhtml_FoxnewsController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('foxnews/foxnews');
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('foxnews');
        return $this;
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $this->_title($this->__('Site News'));
        $this->_initAction()
            ->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $newsId = (int)$this->getRequest()->getParam('id', 0);
        /** @var Fox_News_Model_Resource_Newslist */
        $model = Mage::getModel('news/newslist');

        if ($newsId > 0) {
            $model->load($newsId);
            if (!$model->getId()) {
                Mage::getSingleton('core/session')->addWarning($this->__('No any news found'));
                session_write_close();
                $this->_redirect('*/*/foxnews_foxnewslist');
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Page'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }
        Mage::register('current_news', $model);

        $this->_initAction();
        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('news/newslist');
            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
            }
            $model->setData($data);

            try {
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('news')->__('The page has been saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current'=>true));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('news')->__('An error occurred while saving the page.'));
            }
        }
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('news/newslist');
                $model->load($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('news')->__('The news has been deleted.'));
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('news')->__('Unable to find a news to delete.'));
        $this->_redirect('*/*/');
    }
}
