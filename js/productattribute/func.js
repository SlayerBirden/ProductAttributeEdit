var OptionManager = Class.create();
OptionManager.prototype = {
    initialize: function(sendUrl, optionHtml) {
        this.sendUrl = sendUrl;
        this.optionHtml = optionHtml;
    },
    addOneOption : function(attrId, button) {
        var tr;
        var htmlToAdd;

        tr = button.up().up();
        var tmp = new Template(this.optionHtml);
        htmlToAdd = tmp.evaluate({attrId: attrId});
        tr.insert({after:htmlToAdd});
    },
    removeOption: function(button) {
        var tr;

        tr = button.up().up();
        tr.remove();
    },
    sendOption: function(button) {
        var value;
        var attrCode;

        value = button.up().select('input')[0].value;
        if (value == '') {
            alert('Please make sure you\'ve entered option name.');
            return;
        }
        attrCode = button.getAttribute('alt');
        this.lastValue = value;
        this.lastCode = attrCode;
        this.sendButton = button;

        new Ajax.Request(this.sendUrl, {
            parameters: 'attr_code='+attrCode+'&value='+value,
            method:'post',
            onCreate: this.onReadySend.bind(this),
            onSuccess: this.onSuccessSend.bind(this),
            onComplete: this.onCompleteSend.bind(this)
        });
    },
    onReadySend: function() {
        if (this.sendButton) {
            this.sendButton.addClassName('disabled');
            this.sendButton.disabled = true;
        }
    },
    onSuccessSend: function(transport) {
        var response = {};
        if (transport && transport.responseText){
            try{
                response = eval('(' + transport.responseText + ')');
            }
            catch (e) {
                response = {};
            }
        }
        if (response.error) {
            if (response.error_message.length > 0)
                alert(response.error_message);
        } else {
            if (response.option_id) {
                $(this.lastCode).insert('<option value="'+response.option_id+'">'+this.lastValue+'</option>');
                this.removeOption(this.sendButton); // remove tr
            }
        }
    },
    onCompleteSend: function() {
        if (this.sendButton && typeof this.sendButton != 'undefined') {
            this.sendButton.removeClassName('disabled');
            this.sendButton.disabled = false;
        }
    }
};
