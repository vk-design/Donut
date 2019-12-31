jQuery(document).ready(function(jQuery) {
	var __cancel = jQuery('#cancel-comment-reply-link'),
		__cancel_text = __cancel.text(),
		__list = 'comment-list';//your comment wrapprer
		var submit_button = jQuery('#submit');
		submit_button.before('<p id="comment_message" class="comment_message" style="display: none;"></p>');
		var tipMessage = jQuery('#comment_message');

	jQuery(document).on("submit", "#commentform", function() {
		submit_button.attr('disabled',true).fadeTo(500,.5);
		jQuery.ajax({
			url: ajaxcomment.ajax_url,
			data: jQuery(this).serialize() + "&action=ajax_comment",
			type: jQuery(this).attr('method'),
			beforeSend: function() {
				tipMessage.removeClass('error success');
				addComment.createButterbar("正在提交……");
			},
			error: function(request) {
				var t = addComment;
				tipMessage.addClass('error');
				t.createButterbar('<i class="icon-close"></i> ' + request.responseText);
			},
			success: function(data) {
				jQuery('textarea').each(function() {
					this.value = ''
				});
				var t = addComment,
					cancel = t.I('cancel-comment-reply-link'),
					temp = t.I('wp-temp-form-div'),
					respond = t.I(t.respondId),
					post = t.I('comment_post_ID').value,
					parent = t.I('comment_parent').value;
				if (parent != '0') {
					jQuery('#respond').before('<ol class="children">' + data + '</ol>');
				} else if (!jQuery('.' + __list ).length) {
					if (ajaxcomment.formpostion == 'bottom') {
						jQuery('#respond').before('<ol class="' + __list + '">' + data + '</ol>');
					} else {
						jQuery('#respond').after('<ol class="' + __list + '">' + data + '</ol>');
					}

				} else {
					if (ajaxcomment.order == 'asc') {
						jQuery('.' + __list ).append(data); // your comments wrapper
					} else {
						jQuery('.' + __list ).prepend(data); // your comments wrapper
					}
				}
				tipMessage.addClass('success');
				t.createButterbar("OK:提交成功");
				cancel.style.display = 'none';
				cancel.onclick = null;
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp)
				}
			}
		});
		return false;
	});
	addComment = {
		moveForm: function(commId, parentId, respondId) {
			var t = this,
				div, comm = t.I(commId),
				respond = t.I(respondId),
				cancel = t.I('cancel-comment-reply-link'),
				parent = t.I('comment_parent'),
				post = t.I('comment_post_ID');
			__cancel.text(__cancel_text);
			t.respondId = respondId;
			if (!t.I('wp-temp-form-div')) {
				div = document.createElement('div');
				div.id = 'wp-temp-form-div';
				div.style.display = 'none';
				respond.parentNode.insertBefore(div, respond)
			}!comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
			jQuery("body").animate({
				scrollTop: jQuery('#respond').offset().top - 180
			}, 400);
			parent.value = parentId;
			cancel.style.display = '';
			cancel.onclick = function() {
				var t = addComment,
					temp = t.I('wp-temp-form-div'),
					respond = t.I(t.respondId);
				t.I('comment_parent').value = '0';
				if (temp && respond) {
					temp.parentNode.insertBefore(respond, temp);
					temp.parentNode.removeChild(temp);
				}
				this.style.display = 'none';
				this.onclick = null;
				return false;
			};
			try {
				t.I('comment').focus();
			} catch (e) {}
			return false;
		},
		I: function(e) {
			return document.getElementById(e);
		},
		clearButterbar: function(e) {
			if (jQuery("#comment_message").length > 0) {
				jQuery("#comment_message").hide();
			}
		},
		createButterbar: function(message) {
			var t = this;
			t.clearButterbar();
			tipMessage.html(message).show();
			setTimeout("jQuery('#comment_message').hide().removeClass('error success');jQuery('#submit').attr('disabled',false).fadeTo(500,1);", 3000);
		}
	};
});
// 评论分页
jQuery(document).ready(function($) {
    $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');//commentnav ajax
    $(document).on('click', '.commentnav a', function(e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            beforeSend: function() {
                $('.commentnav').remove();
                $('.commentlist').remove();
            },
            dataType: "html",
            success: function(out) {
                result = $(out).find('.commentlist');
                nextlink = $(out).find('.commentnav');
                $('.mark-comment').after(result);
				$body.animate({scrollTop: $('.comment-title').offset().top -50}, 600 );
                $('.commentlist').after(nextlink);
            }
        });
    });    
});
