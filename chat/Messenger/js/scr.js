
var CustomWidget = function () {
    var self = this;
    
    this.sendInfo = function (string) { 
        self.crm_post(
        'https://print.phuketpost.ru/createLink.php',
        {
          // Передаем POST данные
          action: "update",
          id: AMOCRM.data.current_card.id,
          value: string
        },
        function (msg) {
        },
        'json'
      );
    };
    
    this.callbacks = {
            render: function(){
                return true;
            },
            init: function(){     
                
                self.sendInfo("https://print.phuketpost.ru/createLink.php?id=" + AMOCRM.data.current_card.id);                
                
                var fields = $(".linked-form__cf.text-input");
                for (var i = 0; i < fields.length; i++) 
                {
                    if(fields[i].getAttribute('Name') == 'CFV[461721]')
                    {
                        fields[i].setAttribute('Value', "https://print.phuketpost.ru/createLink.php?id=" + AMOCRM.data.current_card.id);                        
                    }                     
                }
                
                
                return true;
            },
            bind_actions: function(){
                return true;
            },
            settings: function(){
                return true;
            },
            onSave: function(){

                return true;
            },
            destroy: function(){

            }
    };
    return this;
};

