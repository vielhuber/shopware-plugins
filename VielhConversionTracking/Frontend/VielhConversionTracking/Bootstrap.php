<?php
class Shopware_Plugins_Frontend_VielhConversionTracking_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{

	public function getCapabilities()
	{
		return array(
			'install' => true,
			'update' => true,
			'enable' => true
		);
	}
 
	public function getLabel()
	{
		return 'Conversion Tracking Google Analytics';
	}
 
	public function getVersion()
	{
		return '1.0.0';
	}
 
	public function getInfo()
	{
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
 
    public function install()
    {
        $this->registerEvents(); 
        return array('success' => true, 'invalidateCache' => array('frontend'));
    }
	 
    public function registerEvents()
    {
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatch_Frontend',
            'add_custom_javascript'
        );
    }
	
	public function add_custom_javascript(Enlight_Event_EventArgs $args)
	{
	    $controller = $args->get('subject');
	    $view = $controller->View();
	    $view->addTemplateDir(__DIR__.'/Views');
	    $view->extendsTemplate('frontend/plugins/conversion_tracking/index/index.tpl');
    }  

}