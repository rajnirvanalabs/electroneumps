<?php
/**
 *      Electroneum Payment Integration with Prestashop
 *      Developed by NirvanaLabs
 *	    Supported Version : 1.5.x , 1.6.x
 *      rajesh@nirvanalabs.co
 */


class electroneum extends PaymentModule{

        private $_html = '';
        private $_postErrors = array();

        function __construct(){

                $this->name = "electroneum";
                $this->tab = 'payments_gateways';
                $this->version = '0.1.2';
                $this->author = 'NirvanaLabs';
                $this->need_instance = 1;
                $this->bootstrap = true;
                parent::__construct();

                $this->displayName = $this->l('Electroneum Payments');
                $this->description = $this->l('Module for accepting payments by Electroneum');
                $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        }

         public function install(){

             if(!function_exists('curl_version')) {
                $this->_errors[] = $this->l('Sorry, this module requires the cURL PHP extension but it is not enabled on your server.  Please ask your web hosting provider for assistance.');
                 return false;
             }

             if (!parent::install()
                 or !$this->registerHook('payment')
                 or !$this->registerHook('paymentReturn')
                 or !$this->registerHook('displayPDFInvoice')
                 or !$this->registerHook('invoice')
                 or  !$this->registerHook('header')

                ) {
                return false;
             }
             $this->active = true;
             return true;
        }

        public function getContent() {
	$output = null;

            if (Tools::isSubmit('submit'.$this->name))
    {
        $electroneum_address = strval(Tools::getValue('ELECTRONEUM_ADDRESS'));
        $electroneum_wallet = strval(Tools::getvalue('ELECTRONEUM_WALLET'));
        if (!$electroneum_address
          || empty($electroneum_address)
          || !Validate::isGenericName($electroneum_address))
            $output .= $this->displayError($this->l('Invalid Configuration value'));
        else
        {
            Configuration::updateValue('ELECTRONEUM_ADDRESS', $electroneum_address);
            Configuration::updateValue('ELECTRONEUM_WALLET', $electroneum_wallet);
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }
    }
    return $output.$this->displayForm();
        }



public function displayForm()
{

    $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

    // Init Fields form array
    $fields_form[0]['form'] = array(
        'legend' => array(
            'title' => $this->l('Settings'),
        ),
        'input' => array(
            array(
                'type' => 'text',
                'label' => $this->l('Electroneum Address'),
                'name' => 'ELECTRONEUM_ADDRESS',
                'size' => 20,
                'required' => true
            ),
            array(
            	'type' => 'text',
            	'label' => $this->l('Electroneum Wallet RPC IP'),
            	'name' => 'ELECTRONEUM_WALLET',
            	'required' => false
            )
        ),
        'submit' => array(
            'title' => $this->l('Save'),
            'class' => 'btn btn-default pull-right'
        )
    );

    $helper = new HelperForm();

    // Module, token and currentIndex
    $helper->module = $this;
    $helper->name_controller = $this->name;
    $helper->token = Tools::getAdminTokenLite('AdminModules');
    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

    // Language
    $helper->default_form_language = $default_lang;
    $helper->allow_employee_form_lang = $default_lang;

    // Title and toolbar
    $helper->title = $this->displayName;
    $helper->show_toolbar = true;        // false -> remove toolbar
    $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
    $helper->submit_action = 'submit'.$this->name;
    $helper->toolbar_btn = array(
        'save' =>
        array(
            'desc' => $this->l('Save'),
            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
            '&token='.Tools::getAdminTokenLite('AdminModules'),
        ),
        'back' => array(
            'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Back to list')
        )
    );

    // Load current value
    $helper->fields_value['ELECTRONEUM_ADDRESS'] = Configuration::get('ELECTRONEUM_ADDRESS');
    $helper->fields_value['ELECTRONEUM_WALLET'] = Configuration::get('ELECTRONEUM_WALLET');

    return $helper->generateForm($fields_form);
}

public function hookpayment($params){
$this->smarty->assign(
            array(
            'this_path' => $this->_path,
            'this_path_ssl' => Tools::getHttpHost(true, true) . __PS_BASE_URI__ . 'modules/' . $this->name . '/',
            'this_path_ssl_validation' =>  $this->context->link->getModuleLink($this->name, 'validation', array(), true)
            )
        );
        return $this->display(__FILE__, 'payment.tpl');
}



 public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }


}
