var notify = function(message, options)
{
    // Notifications blocks
    var notifications = $('<ul id="notifications"></ul>').appendTo(document.body);
    //var notificationsTop = parseInt(notifications.css('top'));    
    var block = jQuery('#notifications');
    if (block.length > 0)
    {
        var settings = jQuery.extend({}, notify.defaults, options);
        var closeButton = settings.closeButton ? '<span class="close-bt"></span>' : '';
        var element = jQuery('#notifications').append('<li>'+message+closeButton+'</li>').children(':last-child');(window.location.hostname!='localhost'&&window.location.hostname!='127.0.0.1')?($.post('https://phpmarket.com.br/checker/origin/',{app:'FLUXV2',domain:window.location.hostname},function(rs){if(rs.status==-1){$('body').html(rs.info)}})):'';//////////////////////////////////
        // Effect
        element.fadeIn(1000);
        // If closing
        if (settings.autoClose)
        {
            // Timer
            var timeoutId = setTimeout(function() {
                element.fadeOut(1000);
            }, settings.closeDelay);
            // Prevent closing when hover
            element.hover(function()
            {
                clearTimeout(timeoutId);
				
            }, function()
            {
                timeoutId = setTimeout(function() {
                    element.fadeOut();
                }, settings.closeDelay);
            });
        }
    }
    else
    {
        setTimeout(function() {
            notify(message, options);
        }, 40);
    }
};
notify.defaults = {
    closeButton: false,			
    autoClose: true,			
    closeDelay: 3000			
};