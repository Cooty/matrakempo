APP.Share = (function() {
	var $threadColumn,
		faceBookAPIisLoaded = false;

    // public functions
    function init() {
        initDOMElements();
        initBindings();
    }

    // get DOM elements
    function initDOMElements() {
		$threadColumn = $('[data-thread-column]');
    }

    // event bindings
    function initBindings() {
		// catch the click on each share button
		$threadColumn.on({
			'click.FBShare': function(e) {
				var clickedBtn = e.target,
					postId = clickedBtn.getAttribute('data-post-to-share'),
					$postTxt = $('[data-post-id="'+ postId +'"]').find('.post-txt'),
					$emailBtn = $(this).siblings('[data-share-email]');

				if ($emailBtn.length > 0) {
					$emailBtn.removeAttr('data-show-bubble');
				}

				sharePostOnFB($postTxt);

			}
		}, '[data-share-facebook]');

		$threadColumn.on({
				'click.TwitShare': function(e) {
					var clickedBtn = e.target,
						postId = clickedBtn.getAttribute('data-post-to-share'),
						$postTxt = $('[data-post-id="'+ postId +'"]').find('.post-txt'),
						$emailBtn = $(this).siblings('[data-share-email]');

					if ($emailBtn.length > 0) {
						$emailBtn.removeAttr('data-show-bubble');
					}

					sharePostOnTwitter($postTxt);
					e.preventDefault();
				}
			}, '[data-share-twitter]');

		$threadColumn.on({
			'click.shareGPlus': function(e) {
				shareOnGPlus();
				e.preventDefault();
			}
		}, '[data-share-gplus]');

		$threadColumn.on({
			'click.toggleEmailForm': function(e) {
				var clickedBtn = e.target;
				toggleEmailSendForm(clickedBtn);
			}
		}, '[data-share-email]');

		$threadColumn.on({
			'click.closeEmailForm': function(e) {
				var closeBtn = $(e.target);
				closeEmailBubble(closeBtn);
				e.preventDefault();
			}
		}, '[data-close-email-form]');

		$threadColumn.on({
			'click.sendEmail': function(e) {
				var sendBtn = $(e.target);
				sendEmail(sendBtn);
			}
		}, '[data-send-email-form]');
    }

	/**
	 * Does FB share with FB API
	 * @postTxt	jQuery Object	the '.post-txt' element as jQuery object
	 * */
	function sharePostOnFB(postTxt) {
		var postAuthorName = postTxt
								.siblings('.post-user-info')
									.find('.user-name').text(),
			roomName = APP.Chat.getCurrentRoomData().title,
			$videoAttachment = postTxt.parents('.post')
				.find('.embed'),
			$imageAttachment = postTxt.parents('.post')
				.find('.post-content-image'),
			videoURL = '',
			imageURL = '',
			linkToShare = window.location.host,
			faceBookAppID = '';

		if($videoAttachment.length) {
			videoURL = getYTURL($videoAttachment);
		}

		if($imageAttachment.length) {
			imageURL = getImageURL($imageAttachment);
		}

		// prevent scroll pager when the FB.ui pop-up scrolls to top
		$threadColumn.attr('data-pager', 'off');

		if(videoURL.length) {
			linkToShare = videoURL;
		}
		if(imageURL.length) {
			linkToShare = imageURL
		}
		else if(imageURL.length && videoURL.length) {
			linkToShare = imageURL;
		}

		if(!faceBookAPIisLoaded) {
			$.getScript('//connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v2.0', function() {
				faceBookAPIisLoaded = true;
				faceBookAppID = $('[property="og:fb:app_id"]').attr('content');

				FB.init({
					appId: faceBookAppID,
					status: true,
					xmlfb: true,
					version: 'v2.0'
				});

				callFBui(linkToShare, postAuthorName, roomName, postTxt);
			});
		}
		else {
			callFBui(linkToShare, postAuthorName, roomName, postTxt);
		}

	}

	/**
	 * Helper function to access FB.ui() method from the Facebook API
	 * */
	function callFBui(linkToShare, postAuthorName, roomName, postTxt) {
		FB.ui({
			method: 'feed',
			link: linkToShare,
			caption: postAuthorName + ' ezt írta a(z) ' + roomName + ' szobába',
			description: getCleanedPostTxt(postTxt[0])
		}, function() {
			$threadColumn.removeAttr('data-pager');
		});
	}

	/**
	 * Opens a Twitter Webintent pop-up (https://dev.twitter.com/docs/intents) and passes it the text content
	 * trimmed to 140 characters if longer
	 * @postTxt	jQuery Object	the .post-txt as
	 * */
	function sharePostOnTwitter(postTxt) {
		var postTxtContent = getCleanedPostTxt(postTxt[0]),
			$post = postTxt.parents('.post'),
			$videoAttachment = $post.find('.embed'),
			$imageAttachment = $post.find('.post-content-image'),
			postDate = $post.find('.post-date').text(),
			videoURL = ($videoAttachment.length ? getYTURL($videoAttachment) : ''),
			imageURL = ($imageAttachment.length ? getImageURL($imageAttachment) : ''),
			roomName = APP.Chat.getCurrentRoomData().title,
			txt = (postTxtContent.length > 140 ? encodeURI(postTxtContent.substring(0, 137) + '...') : encodeURI(postTxtContent)),
			tweetTxt = txt,
			tweetURL = encodeURI(window.location.href),
			intentURL,
			windowOptions = 'scrollbars=yes,resizable=yes,toolbar=no,location=yes',
			popUpwidth,
			popUpHeight,
			tweetPrefix = 'SportTV Live - ',
			watchImageTxt = 'Nézd meg ezt a képet!';

		if(videoURL.length) {
			tweetURL = encodeURI(videoURL);
			tweetTxt = tweetPrefix + roomName + ' ' + videoURL;
		}
		else if(imageURL.length) {
			tweetURL = encodeURI(imageURL);
			tweetTxt = tweetPrefix + watchImageTxt + ' ' + roomName + ': ' + postDate + ' ' + window.location.host;
		}

		intentURL = 'https://twitter.com/intent/tweet?text=' + tweetTxt + '&amp;via=Sport1TVhu' + '&amp;' + tweetURL;

		if(APP.CheckScreen.isLargeScreen()) {
			popUpwidth = 550;
			popUpHeight = 420;
		}
		else {
			popUpwidth = 320;
			popUpHeight = 460;
		}

		window.open(intentURL, 'intent', windowOptions + ',width=' + popUpwidth +
			',height=' + popUpHeight);

	}

	/**
	 * Helper for getting the content of the post we want to share, strips HTML and whitespaces
	 * @objPostContent	DOMElement	the container of the post's data
	 * */
	function getCleanedPostTxt(objPostTxt) {
		var postTxtCleanedHTML = objPostTxt.innerHTML.replace(/(<([^>]+)>)/ig,"");
		return postTxtCleanedHTML.trim();
	}

	/**
	 * Gets the video embed's data url and retruns it
	 * @$embedObj	the video preview element found in a post element
	 * */
	function getYTURL($embedVideo) {
		return $embedVideo.attr('data-href');
	}

	function getImageURL($embededImage) {
		return $embededImage.attr('src');
	}

	/**
	 * Toggles the bubble containing the email sender form in each email share button
	 * @emailBtn	HTML DOM Element	the clicked email share button
	 * */
	function toggleEmailSendForm(emailBtn) {
		var postShare = emailBtn.parentNode,
			$emailBtn = $(emailBtn),
			bubbleModifierClass = 'bubble-down',
			emailBtnTop,
			emailFormH = 130; // the approximate height of the opened email form bubble

		$emailBtn.removeClass(bubbleModifierClass);
		emailBtnTop = parseInt($emailBtn.offset().top, 10) - 62; // the vertical distance of the email button from the window's top edge, also subtract the overlapping 'fixed' header

		if(emailBtnTop < emailFormH) {
			$emailBtn.addClass(bubbleModifierClass);
		}

		if(!emailBtn.hasAttribute('data-show-bubble')) {
			emailBtn.setAttribute('data-show-bubble', 'true');
			postShare.setAttribute('data-bubble-is-opened', 'true');
		} else {
			emailBtn.removeAttribute('data-show-bubble');
			postShare.removeAttribute('data-bubble-is-opened');
		}
	}

	/**
	 * Closes the email popup bubble
	 * @closeBtn	jQuery Object	the clicked close button in the bubble as jQuery object
	 * */
	function closeEmailBubble(closeBtn) {
		var $emailBtn = closeBtn.parents('[data-show-bubble]');
		var $postShare = closeBtn.parents('[data-bubble-is-opened]');

		$emailBtn.removeAttr('data-show-bubble');
		$postShare.removeAttr('data-bubble-is-opened');
	}

	/**
	 * Sends the post's text to a webservice for email sending, closes and resets the email form bubble if send is succesful
	 * sends feedback to the user
	 * @sendBtn		jQuery Object	the send button in the form bubble as jQuery object
	 * */
	function sendEmail(sendBtn) {
		var $post = sendBtn.parents('.post'),
			$closeBtn = $post.find('[data-close-email-form]'),
			$mailtoAddrInput = $post.find('[data-mailto-input]'),
			$videoAttachment = $post.find('.embed'),
			vidLink = ($videoAttachment.length ? encodeURI($videoAttachment.attr('data-href')) : ''),
			$imageAttachment = $post.find('.post-content-image'),
			imageLink = ($imageAttachment.length ? encodeURI($imageAttachment.attr('src')) : ''),
			postTxt = getCleanedPostTxt($post.find('.post-txt')[0]) + ' ' + vidLink + ' ' + imageLink,
			roomName = APP.Chat.getCurrentRoomData().title,
			mailtoAddrVal = $mailtoAddrInput.val(),
			mailtoAddr = mailtoAddrVal.match(/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/) ? mailtoAddrVal : null,
			sendData = null;

		if(mailtoAddr !== null) {
			$mailtoAddrInput.attr('disabled', 'true');
			sendBtn.attr('disabled', 'true');

			sendData = {'ToEmail':mailtoAddr,'RoomName':roomName,'Text':postTxt};

			$.ajax({
				type: 'POST',
				url: '/services/Sport1TVDataService.svc/emailsend',
				contentType: 'application/json',
				dataType: 'json',
				data: JSON.stringify(sendData)
			})
				.done(function(data){
					if(data.isSuccess) {
						APP.UIControls.showTopMessage(APP.Main.uiMessages.emailSendSuccess);

						$mailtoAddrInput.val('');
						$closeBtn.trigger('click.closeEmailForm');
					}
					else {
						APP.UIControls.showTopMessage(data.errorMessage);
					}
				})
				.fail(function(){
					APP.UIControls.showTopMessage(APP.Main.uiMessages.errEmailSendFail);
				})
				.always(function(){
					$mailtoAddrInput.removeAttr('disabled');
					sendBtn.removeAttr('disabled');
				});
		}
		else {
			APP.UIControls.showTopMessage(APP.Main.uiMessages.errInvalidEmail);
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

    return {
        init: init
    };

}());