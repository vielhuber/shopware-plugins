<?php
class Shopware_Plugins_Frontend_VielhStockDisable_Bootstrap extends Shopware_Components_Plugin_Bootstrap
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
		return 'Varianten deaktivieren bei ungenügendem Lagerbestand';
	}
 
	public function getVersion()
	{
		return '1.0.0';
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
            'Shopware_Modules_Order_SendMail_BeforeSend',
            'disable_sold_out_variants'
        );
    }
	 
    public function disable_sold_out_variants(Enlight_Event_EventArgs $args)
    {
        // loop through articles
        $article = Shopware()->Db()->fetchAll('SELECT * FROM s_order_details WHERE ordernumber = ?', [$args->getSubject()->sOrderNumber]);
        foreach($article as $a)
        {            
			// get current stock of this variant
			$instock = Shopware()->Db()->fetchOne('SELECT instock FROM s_articles_details WHERE articleID = ? AND ordernumber = ?', [$a['articleID'], $a['articleordernumber']]);
			// if stock is leq 0, set to inactive
			if($instock <= 0)
			{
				Shopware()->Db()->query('UPDATE s_articles_details SET active = ? WHERE articleID = ? AND ordernumber = ?', [0,$a['articleID'],$a['articleordernumber']]);
			}     
			// if all variants are inactive, set main article inactive
			$count_active = Shopware()->Db()->fetchOne('SELECT COUNT(ID) FROM s_articles_details WHERE articleID = ? AND active = ?', [$a['articleID'],1]);
			if($count_active == 0)
			{
				Shopware()->Db()->query('UPDATE s_articles SET active = ? WHERE ID = ?', [0,$a['articleID']]);
			}
        }    
    }

}