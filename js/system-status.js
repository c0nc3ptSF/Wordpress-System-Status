systemStatus = {
  
  message: {
    
    messageSwitch: document.getElementById("ss-message-switch"),
    
    enabledVal:  document.getElementById("ss-message-enabled"),
    
    typeVal: document.getElementById("ss-message-type-val"),
    
    status: function(){
    
     var switchStatus = systemStatus.message.enabledVal.value;
     return switchStatus;
    
    },
  
    toggle: function(){
     
      switch(systemStatus.message.status()){
        case "0":
          systemStatus.message.messageSwitch.value = "Enabled";
          jQuery(systemStatus.message.messageSwitch).addClass('button-primary')
          systemStatus.message.enabledVal.value = "1";
          break;
        case "1":
          systemStatus.message.messageSwitch.value = "Disabled";
          jQuery(systemStatus.message.messageSwitch).removeClass('button-primary')
          systemStatus.message.enabledVal.value = "0";
          break;
        default:
          break;
      }
    
    },
    
    postTypeToggle: function(ele){
      
     status = jQuery(ele).next().val();
      
     switch(status){
       case "0":
         jQuery(ele).addClass('button-primary');
         jQuery(ele).next().val("1");
         break;
       case "1":
         jQuery(ele).removeClass('button-primary');
         jQuery(ele).next().val("0");
         break;
     }
    
    },
    
    typeSwitch: function(ele){
      if(systemStatus.message.typeVal.value === ele.getAttribute("data-type")){
        
        jQuery(ele).removeClass("button-primary");
        systemStatus.message.typeVal.value = "0";
        return;
        
      }
      
      systemStatus.message.typeVal.value = ele.getAttribute("data-type");
      
      jQuery(ele).siblings().removeClass("button-primary");
      jQuery(ele).addClass("button-primary");
      
    }
    
  }
  
}

jQuery(systemStatus.message.messageSwitch).click(function(){
  systemStatus.message.toggle();
});

jQuery(".ss-message-type").click(function(event){
  systemStatus.message.typeSwitch(event.target);
});

jQuery(".ss-message-apply").click(function(event){
  systemStatus.message.postTypeToggle(event.target);
});