{extends file="parent:frontend/index/index.tpl"}

{block name="frontend_index_header_javascript_jquery" append}

    <script type="text/javascript">
    function voucherShowMessage(message)
    {
        document.querySelector('.content-main').insertAdjacentHTML('afterbegin','<span class="voucher_link_message">'+message+'</span>');
    }
    function voucherGetVoucher() { 
        var query = window.location.search.substring(1);
        var vars = query.split('&');
        for(var i=0; i < vars.length; i++)
        {
            var pair = vars[i].split('=');
            if(pair[0] == 'voucher' && pair[1] != '')
            {
                return pair[1];
            }
        }
        return null;
    }
    function voucherSaveCookie()
    {
        var code = voucherGetVoucher('voucher');
        document.cookie = 'voucher'+'='+encodeURIComponent(code)+'; '+'expires='+((new Date((new Date()).getTime() + (1*24*60*60*1000))).toUTCString())+'; path=/';
    }
    function voucherApplyVoucher()
    {
        if( document.querySelector('.add-voucher--field') === null )
        {
            return;
        }
        if( document.cookie === undefined || document.cookie.indexOf('voucher') === -1 )
        {
            return;
        }
        var voucher = document.cookie.match(new RegExp('voucher' + '=([^;]+)'));
        voucher = decodeURIComponent(voucher[1]);
        document.cookie = 'voucher=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
        document.querySelector('.add-voucher--field').value = voucher;
        document.querySelector('.add-voucher--button').click();
    }
    window.onload = function()
    { 
        {if $type == 'notice'}
            // store get parameter if possible
            if( voucherGetVoucher('voucher') !== null )
            {
                voucherSaveCookie();
            }
            // show message if cookie is set (also for all further requests)
            if( document.cookie !== undefined && document.cookie.indexOf('voucher') > -1 )
            {
                voucherShowMessage('Der Gutscheincode wird eingelöst, sobald Sie einen <strong>Artikel in den Warenkorb</strong> legen!');
            }
        {elseif $type == 'apply'}
            voucherApplyVoucher();
        {/if}
    }
    </script>
    
{/block}