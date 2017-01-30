   <?php
/*
    CallMe-Server: It's a software for sending callback requests from web sites
    
    file: finish.php

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
*/

ob_start();

include_once './createDB.php';


$ip=$_POST['ip'];
$user=$_POST['user'];
$pass=$_POST['pass'];
$db=$_POST['db'];
$cm_host=$_POST['cm_host'];
$cm_pass=$_POST['cm_pass'];

ob_get_clean();


$cfg= file_get_contents("./config.php");

if($cfg ===false){
    echo('{"result": "-1","descr":"File reading error "}');
    return;  
}


$cfg= str_replace("%%ADDR%%", $ip, $cfg);
$cfg= str_replace("%%USER%%", $user, $cfg);
$cfg= str_replace("%%PASS%%", $pass, $cfg);
$cfg= str_replace("%%DB%%", $db, $cfg);
$cfg= str_replace("%%OPPASS%%", $cm_pass, $cfg);

//umask(0);

unlink("../config.php");
$r=file_put_contents("../config.php", $cfg);



if($r ===false){
    echo('{"result": "-1","descr":"File writing error <config.php>"}');
    return;  
}




$cfg= file_get_contents("./callme.js");

if($cfg ===false){
    echo('{"result": "-1","descr":"File reading error "}');
    return;  
}

$p= strpos($cfg, "/*");
$cfg= substr($cfg, $p);


$cfg="var CALLME_SERVER=\"".$cm_host."\";\r\n".$cfg;

unlink("../callme.js");
$r=file_put_contents("../callme.js", $cfg);

if($r ===false){
    echo('{"result": "-1","descr":"File writing error <callme.js> "}');
    return;  
}


    echo('{"result": "0","descr":"Config files was created "}');
    return;