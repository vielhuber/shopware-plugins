<?php
class Shopware_Plugins_Backend_VielhFeedAttributes_Bootstrap extends Shopware_Components_Plugin_Bootstrap
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
		return 'Feed Smarty Freitextfelder';
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
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_Export',
            'onPostDispatch'
        );
    }

    public function onPostDispatch(Enlight_Event_EventArgs $arguments)
    {
        Shopware()->Template()->addPluginsDir(__DIR__ . '/Views/_private/smarty');
    }

}