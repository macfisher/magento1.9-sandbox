<?php
class   Mdg_Giftregistry_IndexController
extends Mage_Core_Controller_Front_Action
{
	public function preDispatch() {
		if (Mage::getSingleton('customer/session')->authenticate($this)) {
			$this->getResponse()
				 ->setRedirect(Mage::helper('customer')->getLoginUrl());

			$this->setFlag('', self::FLAG_NO_DISPATCH, true);
		}
	}

	public function indexAction() {
		$this->loadLayout();
		$this->renderLayout();
	}

	public function deleteAction() {
		$this->loadLayout();
		$this->renderLayout();
		return $this;
	}

	public function newAction() {
		$this->loadLayout();
		$this->renderLayout();
		return $this;
	}

	public function editAction() {
		$this->loadLayout();
		$this->renderLayout();
		return $this;
	}

	public function newPostAction() {
		try {
			$data     	= $this->getRequest()->getParams();
			$registry 	= Mage::getModel('mdg_giftregistry/entity');
			$customer	= Mage::getSingleton('customer/session')->getCustomer();

			if ($this->getRequest()->getPost() && !empty($data)) {
				$registry->updateRegistryData($customer, $data);
				$registry->save();

				$successMessage = Mage::helper('mdg_giftregistry')
					->__("Registry Successfully Created");

				Mage::getSingleton('core/session')->addSuccess($successMessage);
			} else {
				throw new Exception("Insufficient Data provided");
			}
		} catch (Mage_Core_Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			$this->_redirect('*/*/');
		}

		$this->_redirect('*/*/');
	}

	public function editPostAction() {
		try {
			$data     	= $this->getRequest()->getParams();
			$registry 	= Mage::getModel('mdg_giftregistry/entity');
			$customer	= Mage::getSingleton('customer/session')->getCustomer();

			if ($this->getRequest()->getPost() && !empty($data)) {
				$registry->load($data['registry_id']);

				if ($registry) {
					$registry->updateRegistryData($customer, $data);
					$registry->save();

					$successMessage = Mage::helper('mdg_giftregistry')
						->__("Registry Successfully Saved");

					Mage::getSingleton('core/session')->addSuccess($successMessage);
				} else {
					throw new Exception("Invalid Registry Specified");
				}
			} else {
				throw new Exception("Insufficient Data provided");
			}
		} catch (Mage_Core_Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());

			$this->_redirect('*/*/');
		}

		$this->_redirect('*/*/');
	}
}