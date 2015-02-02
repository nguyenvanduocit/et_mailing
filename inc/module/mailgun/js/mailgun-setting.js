(function (Models, Views, $, Backbone) {
    Views.MailginSetting = Backbone.View.extend({
        events: {
            'click #send_text_email': 'sendTestEmail',
            'change #test_email': 'changeTestEmail'
        },
        test_email: "",
        test_email_field: "",
        send_test_button: null,
        initialize: function () {
            var view = this;
            this.test_email_field = $("#test_email", this.$el);
            this.send_test_button = $("#send_text_email", this.$el);

            this.test_email = $("#test_email", this.$el).val();
            this.blockUi = new Views.BlockUi();
        },
        changeTestEmail: function () {
            this.test_email = $("#test_email", this.$el).val();
        },
        sendTestEmail: function (evt) {
            evt.preventDefault();

            data = {
                action: "mailgun_test",
                test_email: this.test_email
            };
            var view = this;
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
                beforeSend: function () {
                    view.blockUi.block(view.send_test_button);
                },
                success: function (rep) {
                    if(rep.message) {
                        alert(rep.message);
                    }
                },
                error: function (e) {

                },
                complete: function () {
                    view.blockUi.unblock();
                }
            });
        }
    });

    jQuery(document).ready(function ($) {
        var ae_mailing = new Views.MailginSetting({
            el: $("#mailgun-settings")
        });
    });

})(window.AE.Models, window.AE.Views, jQuery, Backbone);