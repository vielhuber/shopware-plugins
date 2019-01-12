{extends file="parent:frontend/detail/config_upprice.tpl"}

{block name="frontend_detail_group_selection"}
    <div class="select-field">
        <select name="group[{$sConfigurator.groupID}]"{if $theme.ajaxVariantSwitch} data-ajax-select-variants="true"{else} data-auto-submit="true"{/if}>
            {foreach $sConfigurator.values as $configValue}
                {* hide not selectable in all groups except in the first group *}
                {if ($configValue.selectable || $sArticle.sConfigurator.0.groupID == $sConfigurator.groupID)}
                    <option{if $configValue.selected} selected="selected"{/if} value="{$configValue.optionID}">
                        {$configValue.optionname}{if $configValue.upprice} {if $configValue.upprice > 0}{/if}{/if}
                    </option>
                {/if}
            {/foreach}
        </select>
    </div>
{/block}