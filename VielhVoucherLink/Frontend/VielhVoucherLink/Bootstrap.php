<?php
class Shopware_Plugins_Frontend_VielhVoucherLink_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{

    public function getCapabilities()
    {
        return [
            'install' => true,
            'update' => true,
            'enable' => true
        ];
    }
 
    public function getLabel()
    {
        return 'Gutscheincode per Link';
    }
 
    public function getVersion()
    {
        return '1.0.5';
    }
 
    public function getInfo()
    {
        return [
            'version' => $this->getVersion(),
            'label' => $this->getLabel(),
            'author' => 'David Vielhuber',
            'supplier' => 'David Vielhuber',
            'description' => $this->getLabel(),
            'support' => 'David Vielhuber',
            'link' => 'https://vielhuber.de'
        ];
    } 
 
    public function install()
    {
        $this->registerEvents();
        return ['success' => true, 'invalidateCache' => ['frontend']];
    }

    public function registerEvents()
    {
        $this->subscribeEvent(
            'Theme_Compiler_Collect_Plugin_Less',
            'add_less'
        );
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatch',
            'add_voucher'
        );
        $this->subscribeEvent(
            'Enlight_Controller_Action_PreDispatch_Frontend_Checkout',
            'add_voucher_checkout'
        );     
    }

    public function add_less(Enlight_Event_EventArgs $args)
    {
        $less = new \Shopware\Components\Theme\LessDefinition([],[
            __DIR__ . '/Views/frontend/plugins/voucher_link/_public/src/less/all.less'
        ],__DIR__);
        return new Doctrine\Common\Collections\ArrayCollection(array($less));
    }

    public function add_voucher(Enlight_Event_EventArgs $args) 
    {
        $request = $args->getSubject()->Request();
        $response = $args->getSubject()->Response();
        $view = $args->getSubject()->View(); 
        if(
            !$request->isDispatched() ||
            $response->isException() ||
            !$view->hasTemplate() ||
            $request->getModuleName() != 'frontend'
        )
        {
            return;
        }
        $view->addTemplateDir(dirname(__FILE__).'/Views/');
        $view->extendsTemplate('frontend/plugins/voucher_link/index/index.tpl');
        $view->assign('type', 'notice');
    }

    public function add_voucher_checkout(Enlight_Event_EventArgs $args) 
    {
        $request = $args->getSubject()->Request();
        $response = $args->getSubject()->Response();
        $view = $args->getSubject()->View(); 
        if($request->getActionName() != 'cart')
        {
            return;
        }
        $view->addTemplateDir(dirname(__FILE__).'/Views/');
        $view->extendsTemplate('frontend/plugins/voucher_link/index/index.tpl');
        $view->assign('type', 'apply');
    }

}