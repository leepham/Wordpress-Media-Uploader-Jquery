(function($) {
    $(function() {
        $.fn.wptuts = function(options) {
            var selector = $(this).selector; // Get the selector
            // Set default options
            var defaults = {
                'preview' : '.preview-upload',
                'text'    : '.text-upload',
                'button'  : '.button-upload',
            };
            var options  = $.extend(defaults, options);

        	// When the Button is clicked...
            $(options.button).click(function() {  
                // Get the Text element.
                var text = $(this).siblings(options.text);
                
                // Show WP Media Uploader popup
                tb_show('Upload a logo', 'media-upload.php?referer=wptuts&type=image&TB_iframe=true&post_id=0', false);
        		
        		// Re-define the global function 'send_to_editor'
        		// Define where the new value will be sent to
                window.send_to_editor = function(html) {
                	// Get the URL of new image
                    var src = $('img', html).attr('src');
                    // Send this value to the Text field.
                    text.attr('value', src).trigger('change'); 
                    tb_remove(); // Then close the popup window
                }
                return false;
            });

            $(options.text).bind('change', function() {
            	// Get the value of current object
                var url = this.value;
                // Determine the Preview field
                var preview = $(this).siblings(options.preview);
                // Bind the value to Preview field
                $(preview).attr('src', url);
            });
        }

        // Usage
        $('.upload').wptuts(); // Use as default option.
    });
}(jQuery));
