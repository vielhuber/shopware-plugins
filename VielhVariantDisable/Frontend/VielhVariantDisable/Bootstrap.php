<?php
class Shopware_Plugins_Frontend_VielhVariantDisable_Bootstrap extends Shopware_Components_Plugin_Bootstrap {
	public function getCapabilities() {
		return array(
			'install' => true,
			'update' => true,
			'enable' => true
		);
	}
 
	public function getLabel() {
		return 'Variantenauswahl auf Detailseite: Blende inaktive Varianten aus';
	}
 
	public function getVersion() {
		return '1.0.0';
	}
 
	public function getInfo() {
		return array(
			'version' => $this->getVersion(),
			'label' => $this->getLabel(),
			'author' => 'David Vielhuber',
			'supplier' => 'David Vielhuber',
			'description' => $this->getLabel(),
			'support' => 'David Vielhuber',
			'link' => 'https://vielhuber.de'
		);
	} 
 
    public function install() {
        $this->registerEvents(); 
        return array('success' => true, 'invalidateCache' => array('frontend'));
    }
	 
    public function registerEvents() {

        // add less
        $this->subscribeEvent(
            'Theme_Compiler_Collect_Plugin_Less',
            'addLessFiles'
        );

        // add js
        $this->subscribeEvent(
            'Theme_Compiler_Collect_Plugin_Javascript',
            'addJsFiles'
        );

        // modify detail
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatch_Frontend_Detail',
            'modify_detail_page'
        );

    }

    public function addLessFiles(Enlight_Event_EventArgs $args) {
        $less = new \Shopware\Components\Theme\LessDefinition(
            array(),
            array(
                __DIR__ . '/Views/frontend/plugins/variant_disable/_public/src/less/all.less'
            ),
            __DIR__
        );
        return new Doctrine\Common\Collections\ArrayCollection(array($less));
    }
    public function addJsFiles(Enlight_Event_EventArgs $args)
    {
        $jsFiles = array(__DIR__ . '/Views/frontend/plugins/variant_disable/_public/src/js/script.js');
        return new Doctrine\Common\Collections\ArrayCollection($jsFiles);
    }
	
	public function modify_detail_page(Enlight_Event_EventArgs $args) {
        $view = $args->getSubject()->view();
        $view->addTemplateDir(dirname(__FILE__).'/Views/');
        $view->extendsTemplate('frontend/plugins/variant_disable/detail/config_upprice.tpl');
    }  

}
?>