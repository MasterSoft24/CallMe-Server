//var CALLME_SERVER="https://www.mastersoft24.ru/";
/*
    CallMe-Server: It's a software for sending callback requests from web sites

    file: callme.js

    Copyright (C) 2016-2017  Vladimir Kamensky
    Copyright (C) 2016-2017  Master Soft LLC.
    All rights reserved


  BSD License

  Redistribution and use in source and binary forms, with or without modification, are
  permitted provided that the following conditions are met:

  - Redistributions of source code must retain the above copyright notice, this list of
    conditions and the following disclaimer.
  - Redistributions in binary form must reproduce the above copyright notice, this list
    of conditions and the following disclaimer in the documentation and/or other
    materials provided with the distribution.
  - Neither the name of the "Vladimir Kamensky" or "Master Soft LLC." nor the names of
    its contributors may be used to endorse or promote products derived from this
    software without specific prior written permission.

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY E
  XPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES O
  F MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SH
  ALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENT
  AL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROC
  UREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS I
  NTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRI
  CT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF T
  HE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/


var CallMeMessages_EN={
  "formCaption": "Leave your phone number and we'll callback to you",
  "nameLabel":"What is your name?",
  "namePlaceholder":"Your name",
  "phoneLabel":"Your phone number?",
  "phonePlaceholder":"Phone number",
  "formButton":"Request a callback",
  "acceptRequest":"Your request is accepted",
  "formButtonLater":"Later"

}

var CallMeMessages_RU={
  "formCaption": "Оставьте свой номер телефона и мы перезвоним вам",
  "nameLabel":"Как к вам обращаться?",
  "namePlaceholder":"Ваше имя",
  "phoneLabel":"Ваш номер телефона?",
  "phonePlaceholder":"Номер телефона (в любом формате)",
  "formButton":"Заказать звонок",
  "acceptRequest":"Ваша заявка принята",
  "formButtonLater":"Позже",
}



var texts={
    "en":CallMeMessages_EN,
    "ru":CallMeMessages_RU
};
//texts["en"]=CallMeMessages_EN;

function CallMeText(){

    
    
    this.defaultLang="en";
    
    this.getText=function(id){
        return texts[this.defaultLang][id];
    }
        
}




jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + 
                                                $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + 
                                                $(window).scrollLeft()) + "px");
    return this;
}



function callMe(){
    
    this.text=new CallMeText();
    

    
    this.append=function(){

        //var wid=Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 5);

        document.writeln("<div class='callmebutton-wrapper' id='callmebutton-wrapper"+"'></div>");


        // apply button
        jQuery("#callmebutton-wrapper").append("\n\
        <div class='callmebutton-box' onClick='CALLME.click()'>\n\
            <div class='callmebutton' >\n\
                <span>"+this.text.getText("formButton")+"</span>\n\
            </div>\n\
        </div>");
        
        // apply form
        document.writeln("<div class='callmeform-wrapper' id='callmeform-wrapper"+"'></div>");
        
        jQuery("#callmeform-wrapper").append("\n\
        <div class='callmeform-box'><div class='callmeform-caption'>"+this.text.getText("formCaption")+"</div>\
        <div class='callme_form_element_box'><label for='callme_name'>"+this.text.getText("nameLabel")+"</label><input placeholder='"+this.text.getText("namePlaceholder")+"' class='callme_form_input' type='text' name='callme_name' id='callme_name'/></div>\
        <div class='callme_form_element_box'><label for='callme_phone'>"+this.text.getText("phoneLabel")+"</label><input placeholder='"+this.text.getText("phonePlaceholder")+"' class='callme_form_input' type='text' name='callme_phone' id='callme_phone'/></div>\
        <div class='callme_form_element_box button'><input onClick='CALLME.send()' type='button' value='"+this.text.getText("formButton")+"' />\
        <input onClick='CALLME.formHide();' type='button' value='"+this.text.getText("formButtonLater")+"' /></div>\
        </div>");        
        
        //apply message form        
        document.writeln("<div class='callmemessage-wrapper' id='callmemessage-wrapper"+"'></div>");
        
        jQuery("#callmemessage-wrapper").append("\n\
        <div class='callmemessage-box'>\
        <div class='callme_message_form_text' id='callme_message_form_text'>Message Text</div>\
        <div class='callme_message_form_element_box button'><input onClick='CALLME.messageClick()' type='button' value='OK' /></div>\
        </div>");         
        
    }
    
    
    
    this.click=function(){
        this.formShow();
    }
    
    this.entered=function(){
        
    }
    
    this.leave=function(){
        
    } 
    
    
    this.formShow=function(){
        
        jQuery(".callmeform-box").css("display","block");
        jQuery(".callmeform-box").center();
        
        jQuery( ".callmeform-box" ).fadeTo( 400 , 1,function(){});
   
 
    }
 
    this.messageShow=function(message){
        
        jQuery(".callmemessage-box").css("display","block");
        
        jQuery("#callme_message_form_text").text(message);
        jQuery(".callmemessage-box").center();
        jQuery( ".callmemessage-box" ).fadeTo( 400 , 1,function(){});
        
        setTimeout(function() {
        $(".callmemessage-box").fadeOut('fast');}, 2500); 
    }
    
        this.formHide=function(){

        jQuery( ".callmeform-box" ).fadeTo( 200 ,0,function(){});
   
 
    }
 
    this.messageHide=function(){

        jQuery( ".callmemessage-box" ).fadeTo( 200 ,0,function(){});
    }
    
    
    this.messageClick=function(){
        
        CALLME.messageHide();
    }
    
    
    
    this.send=function(){
        
        var data={};
        
        data.name= jQuery("#callme_name").val();
        data.phone=jQuery("#callme_phone").val();
        data.captha="";
	data.apiVer="1";
        
        $.ajax({
            type: "POST",
            url: CALLME_SERVER+"/callme/data.php",
            data: data,
            success: function(d){
                
                var res= JSON.parse(d);
                
                if(res.result >= 0){// form messages
                    
                    if(res.result == 0){
                        CALLME.formHide();
                        CALLME.messageShow(CALLME.text.getText("acceptRequest"))
                    }
                    else{
                        if(res.result == 1){
                            jQuery("#callme_name").addClass("input_error");
                            jQuery("#callme_phone").removeClass("input_error");
                        }
                        
                        if(res.result == 2){
                            jQuery("#callme_name").removeClass("input_error");
                            jQuery("#callme_phone").addClass("input_error");
                        }                        
                    }
                    
                }
                else{// error messages
                    CALLME.messageShow(res.descr)
                }

            },
            error: function(){
                alert("Internal server error")
            }
            
          });
          

        
    }
    
}

var CALLME=new callMe();