<?php

/**
 * Skroutz Analytics module ”Satyros”
 *
 * @author    tivuno web & marketing solutions
 * @copyright 2018 - 2022 © tivuno web & marketing solutions
 * @license   Basic license | You are allowed to use the software on one productive environment
 */

class Tvskroutzanalytics extends Module
{
    protected $_errors = array();

    public function __construct()
    {
        $this->name = 'tvskroutzanalytics';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->author = 'tivuno web & marketing solutions';
        $this->need_instance = 0;

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Skroutz Analytics simple (NEW SCRIPT)');
        $this->description = $this->l(
            'It sends the required data to Skroutz SA servers in order to track your conversions.'
        );
        $this->confirmUninstall = $this->l('Are you sure you want to delete this module?');

        $this->skroutz_id = Configuration::get('SKROUTZANALYTICS_ID');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('orderConfirmation')
            && $this->registerHook('header');
    }

    public function getContent()
    {
        $html = '';

        if (Tools::isSubmit('submitUpdate')) {
            Configuration::updateValue('SKROUTZANALYTICS_ID', Tools::getValue('accountid'));
            $html .= $this->displayConfirmation($this->l('Settings Updated'));
        }

        $html .= '
		<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" class="defaultForm form-horizontal">
			<div class="panel">
				<div class="panel-heading">' . $this->l('Settings') . '</div>';

        $html .= '
		<div class="form-group">
			<label class="control-label col-lg-3">' . $this->l('Shop Account ID') . '</label>
			<div class="col-lg-6">
				<input type="text" name="accountid" value="' . Configuration::get('SKROUTZANALYTICS_ID') . '">
			</div>
		</div>
		';

        $html .= '
		<input type="submit" name="submitUpdate" value="' . $this->l('Save') . '" class="btn btn-default">
		';

        $html .= '
			</div>
		</form>
		';

        return $html;
    }

    public function hookHeader()
    {
        $this->context->smarty->assign(array(
            'skroutz_id' => $this->skroutz_id
        ));

        return $this->display(__FILE__, 'skroutzanalyticsscript.tpl');
    }


    public function hookOrderConfirmation($params)
    {
        // var_dump($params['objOrder']);

        $order = $params['objOrder'];
        $products = $order->getProducts();

        // var_dump($products);
        $this->context->smarty->assign(array(
            'order' => $order,
            'order_products' => $products,
            'skroutz_id' => $this->skroutz_id
        ));

        return $this->display(__FILE__, 'skroutzanalytics.tpl');
    }
}
