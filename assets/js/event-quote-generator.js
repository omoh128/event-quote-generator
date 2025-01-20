(function($) {
    'use strict';

    const EventQuoteGenerator = {
        init: function() {
            this.form = $('#event-quote-generator-form');
            this.resultDiv = $('#quote-result');
            // Initially hide the result div
            this.resultDiv.hide();
            
            // Check for HTTPS
            if (window.location.protocol !== 'https:') {
                this.showSecurityWarning();
            }

            // Bind event handlers
            this.bindEvents();
        },

        bindEvents: function() {
            // Attach form submit event
            this.form.on('submit', this.handleSubmit.bind(this));
        },

        showSecurityWarning: function() {
            const warning = $('<div>', {
                class: 'security-warning',
                html: '<strong>Warning:</strong> This form should be submitted over a secure HTTPS connection. ' +
                      'Please contact the site administrator.'
            }).insertBefore(this.form);

            // Disable form submission if not secure
            this.form.find('button[type="submit"]').prop('disabled', true);
        },

        handleSubmit: function(e) {
            e.preventDefault();

            // Double-check for HTTPS
            if (window.location.protocol !== 'https:') {
                this.showSecurityWarning();
                return;
            }

            // Continue with form submission
            this.generateQuote();
        },

        generateQuote: function() {
            const eventType = this.form.find('[name="event_type"]').val();
            const guests = this.form.find('[name="guests"]').val();
            const date = this.form.find('[name="event_date"]').val();
        
            // Send an AJAX request to the REST API
            $.ajax({
                url: '/wp-json/event-quote-generator/v1/generate-quote',
                method: 'POST',
                data: JSON.stringify({
                    event_type: eventType,
                    guests: guests,
                    event_date: date
                }),
                contentType: 'application/json',
                success: (response) => {
                    console.log(response); // Log response for debugging
                    if (response.success) {
                        this.resultDiv.show().html(`<p>Quote: $${response.quote}</p>`);
                    } else {
                        this.resultDiv.show().html('<p>Error: Could not generate quote.</p>');
                    }
                },
                error: (xhr) => {
                    console.error(xhr.responseText); // Log error details
                    this.resultDiv.show().html('<p>An error occurred. Please try again later.</p>');
                }
            });
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        EventQuoteGenerator.init();
    });
})(jQuery);
