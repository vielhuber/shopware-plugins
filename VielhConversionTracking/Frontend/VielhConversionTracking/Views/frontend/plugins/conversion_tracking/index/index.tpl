{extends file="frontend/index/index.tpl"}
{block name="frontend_index_header_javascript_jquery" append}
    <script type="text/javascript">
    function conversionSendEvent(category, action)
    {
    	// legacy code
    	_gaq.push(['_trackEvent', category, action]);
    	// new code
    	//ga('send', { hitType: 'event', eventCategory: category, eventAction: action });
    }
	function conversionCheckScripts()
	{
	  if( typeof ga === 'function' || typeof _gaq != null )
	  {
	    return true;
	  }
	  return false;
	}
	function conversionTrackDuration()
	{
		var timer = 30;
		while((timer/60) <= 8)
		{
			(function(timer)
			{
				window.setTimeout(function()
				{
					conversionSendEvent('duration_time', timer+'s');
				},timer*1000);
			})(timer);
			timer += 30;
		}
	}
	function conversionTrackScrollDepth()
	{
		var scrollDepthTriggered = { 25: false, 50: false, 75: false, 100: false };
		conversionSendEvent('scroll_depth', '0%');
		window.addEventListener('scroll', function()
		{
			var scrollTop = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
			var documentHeight = Math.max(document.body.offsetHeight, document.body.scrollHeight, document.documentElement.clientHeight, document.documentElement.offsetHeight, document.documentElement.scrollHeight);
			var windowHeight = window.innerHeight;
			var scroll = Math.round((scrollTop/(documentHeight-windowHeight))*100);
			for(var scrollDepthTriggered__key in scrollDepthTriggered)
			{
				if(scrollDepthTriggered[scrollDepthTriggered__key] === false && scroll >= scrollDepthTriggered__key) {
					scrollDepthTriggered[scrollDepthTriggered__key] = true;
					conversionSendEvent('scroll_depth', scrollDepthTriggered__key+'%');
				}
			};
		});
	}
	window.onload = function()
	{
	  if( conversionCheckScripts() === false ) { return; }
	  conversionTrackDuration();
	  conversionTrackScrollDepth();
	}
    </script>
{/block}