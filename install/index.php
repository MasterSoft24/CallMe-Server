   <?php
/*
    CallMe-Server: It's a software for sending callback requests from web sites
    
    file: index.php

    Copyright (C) 2016-2017  Vladimir Kamensky
    Copyright (C) 2016-2017  Master Soft LLC.
    All rights reserved.


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
*/?>
   <html>
    <head>
        <title>CallMe Server setup</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <script type="text/javascript" src="jq.1.8.js"></script>
        
        <style>
            
            .step{
                
                border: 2px solid gray;
                width:50%;
                margin:30px;
                padding: 50px;
                border-radius: 10px;
            }
            
            .step-name{
                font-size: 20pt;
                font-family: Times;
/*                margin-top:20px;
                margin-left: 20px;*/
                margin-bottom: 30px;
                text-decoration: underline;
            }
            
            .field{
                width: 100%;
                
                margin-bottom: 20px;
            }
            
            .field label{
                display: inline-block;
                width: 300px;
            }
            
            .field input{
                /*margin-left: 300px;;*/
                /*left: 0px;*/
               display: inline-block;
            }
            
        </style>
        
        <script>
        
        function testConn(){
            var data={};

            data.ip= jQuery("#db_host").val();
            data.user=jQuery("#db_user").val();
            data.pass=jQuery("#db_passwd").val();
            data.db=jQuery("#db_dbname").val();
            

            $.ajax({
                type: "POST",
                url: "./tstConn.php",
                data: data,
                success: function(d){

                    var res= JSON.parse(d);

                        alert(res.descr);

                },
                error: function(d){
                    alert("Internal server error "+JSON.parse(d).descr)
                }

              });            
        }
 
 
        function createDB(){
            var data={};

            data.ip= jQuery("#db_host").val();
            data.user=jQuery("#db_user").val();
            data.pass=jQuery("#db_passwd").val();
            data.db=jQuery("#db_dbname").val();
            

            $.ajax({
                type: "POST",
                url: "./createDB.php",
                data: data,
                success: function(d){

                    var res= JSON.parse(d);

                        alert(res.descr);

                },
                error: function(d){
                    alert("Internal server error "+JSON.parse(d).descr)
                }

              });            
        }


        function finish(){
            var data={};
            
            data.ip= jQuery("#db_host").val();
            data.user=jQuery("#db_user").val();
            data.pass=jQuery("#db_passwd").val();
            data.db=jQuery("#db_dbname").val();
            
            data.cm_host= jQuery("#cm_host").val();
            data.cm_pass=jQuery("#cm_pass").val();
            
            if((jQuery("#cm_pass").val() !== jQuery("#cm_pass2").val())||(jQuery("#cm_pass").val() === "")){
                alert("Passwords missmatch");
                return;
            }
            
            
            $.ajax({
                type: "POST",
                url: "./finish.php",
                data: data,
                success: function(d){

                    var res= JSON.parse(d);

                        alert(res.descr);

                },
                error: function(d){
                    alert("Internal server error "+JSON.parse(d).descr)
                }

              });                
            
            
        }
 
        </script>
        
    </head>
    <body>
        <div style="margin-left: 30px;height: 60px;">
            <img style="display: inline" height="50px" src="../icon.png" />
        <h1 style="display: inline;margin-bottom: 70px; ">CallMe Server setup</h1>
        </div>
        
        <div class="step">
            <div class="step-name">
                Database configuration
            </div>
            
            <div class="field">
                <label for="">Database server (or IP)</label><input type="text" name="" id="db_host" value="" placeholder="" />
            </div>
            <div class="field">
                <label for="">Database user</label><input type="text" name="" id="db_user" value="" placeholder="" />
            </div>
            <div class="field">
                <label for="">Database user password</label><input type="password" name="" id="db_passwd" value="" placeholder="" />
            </div>
            <div class="field">
                <label for="">Database name</label><input type="text" name="" id="db_dbname" value="" placeholder="" />
            </div>
            
            <button onclick="testConn()">Test connection</button>
            <button onclick="createDB()" style="margin-left: 50x;">Create CallMe database structure</button>
            
        </div>
        
        <div class="step">
            <div class="step-name">
                CallMe server configuration
            </div>
            
            <div class="field">
                <label for="">CallMe server URL (i.e. http://somehost.com)</label><input type="text" name="" id="cm_host" value="" placeholder="" />
            </div>
            <div class="field">
                <label for="">CallMe server security password</label><input type="password" name="" id="cm_pass" value="" placeholder="" />
            </div>  
            <div class="field">
                <label for="">Retype security password</label><input type="password" name="" id="cm_pass2" value="" placeholder="" />
            </div>            
        </div>
        
        <div class="step">
            <div style="color:red;font-size: 14px;">Please do not forget after installation finished delete install directory or make it unaccessible from internet</div>
            <br/>
            <button onclick="finish()">FINISH</button>
        </div>
        
    </body>
</html>



<?php



?>