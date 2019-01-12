<?php
function smarty_modifier_loadArticleFreeTextFields($article_id)
{
	$attributes = [];
	$attributes_db = Shopware()->Db()->fetchRow('SELECT * FROM s_articles_attributes WHERE articleID = ?', [$article_id]);
	if(!empty($attributes_db))
	{
		foreach($attributes_db as $attributes_db__key=>$attributes_db__value)
		{
			if( in_array($attributes_db__key, ['id', 'articleID', 'articledetailsID']) ) { continue; }
			$attributes[$attributes_db__key] = $attributes_db__value;
		}
	}
    return $attributes;
}