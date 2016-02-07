// AMD module for the Social Media share buttons on the posts and pages
// @requires    jQuery, loaded by require.js
define('share', ['jquery'], function(jquery) {
	var faceBookAPIisLoaded = false,
		popUpwidth,
		popUpHeight,
		$fbButton = $('[data-fb-share]'),
		$twitButton = $('[data-twit-share]'),
		$gplusButton = $('[data-gplus-share]');			
	
	/**
	 * Set to size of the pop-up windows (G+ and Twitter) for different screen sizes
	*/
	function setPopUpSize() {
		if(document.documentElement.clientWidth <= 640) {
			popUpwidth = 320;
			popUpHeight = 460;
		}
		else {
			popUpwidth = 550;
			popUpHeight = 420;
		}
	}
	
	/**
	 * Bind DOM events
	*/
	function initBindings() {
		$fbButton.on({
			'click.shareFB': sharePostOnFB
		});
		
		$twitButton.on({
			'click.shareTwit': sharePostOnTwitter
		});
		
		$gplusButton.on({
			'click.shareGplus': shareOnGPlus
		});
		
	}
	
	/**
	 * Helper function to access FB.ui() method from the Facebook API
	 * */
	function callFBui(link, caption, description) {
		FB.ui({
			method: 'feed',
			link: link,
			caption: caption,
			description: description
		});
	}
	
	/**
	 * Does FB share with FB API
	 * @postTxt	jQuery Object	the '.post-txt' element as jQuery object
	 * */
	function sharePostOnFB() {
		var linkToShare = window.location.host,
			faceBookAppID = $('[property="og:fb:app_id"]').attr('content'),
			fbDescription = $('[property="og:description"]').attr('content'),
			fbCaption = $('[property="og:title"]').attr('content');
		
		if(!$('#fb-root').length) {
			$.getScript('//connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v2.0', function() {
				faceBookAPIisLoaded = true;
				FB.init({
					appId: faceBookAppID,
					status: true,
					xmlfb: true,
					version: 'v2.0'
				});

				callFBui(linkToShare, fbCaption, fbDescription);
			});
		}
		else {
			callFBui(linkToShare, fbCaption, fbDescription);
		}

	}
	
	/**
	 * Opens a pop-up to Google+'s static share service, with the sites url as passed a parameter
	 * */
	function shareOnGPlus() {
		window.open('https://plus.google.com/share?url= '+ window.location.host + '&hl=hu',
					'',
					'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
	}
	
	/**
	 * Opens a Twitter Webintent pop-up (https://dev.twitter.com/docs/intents)
	 * @postTxt	jQuery Object	the .post-txt as
	 * */
	function sharePostOnTwitter() {
		var tweetURL = encodeURI(window.location.href),
		tweetTitle = encodeURI($('[name="twitter:title"]').attr('content')),
			intentURL,
			windowOptions = 'scrollbars=yes,resizable=yes,toolbar=no,location=yes';

		intentURL = 'https://twitter.com/intent/tweet?text=' + tweetTitle + '&amp;url=' + tweetURL;

		window.open(intentURL, 'intent', windowOptions + ',width=' + popUpwidth +
			',height=' + popUpHeight);

	}
	
	return {
		init: function() {
			setPopUpSize();
			initBindings();
		}
	}
    
});