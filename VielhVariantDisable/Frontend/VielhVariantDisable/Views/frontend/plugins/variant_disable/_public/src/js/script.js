document.asyncReady(function() {
(function($) {

    $.overridePlugin('swAjaxVariant', {
        onChange: function(event) {
            // on all detail pages that have more than one variant group, always reset other groups
            if( $('body.is--ctl-detail').length > 0 ) {
                if( $('.product--configurator .configurator--label').length >= 2 ) {
                    $(event.target).closest('.select-field').nextAll('.select-field').find('select').removeAttr('name');
                }
            }

            // the rest of the function stays the same
            var $target = $(event.target),
                $form = $target.parents('form'),
                values = {};
            $.each($form.serializeArray(), function (i, item) {
                if (item.name === '__csrf_token') {
                    return;
                }
                values[item.name] = item.value;
            });
            event.preventDefault();
            if (!this.hasHistorySupport) {
                $.loadingIndicator.open({
                    closeOnClick: false,
                    delay: 0
                });
                $form.submit();
                return false;
            }
            $.publish('plugin/swAjaxVariant/onChange', [this, values, $target]);
            this.requestData(values, true);            
        }
    });

})(jQuery);
});