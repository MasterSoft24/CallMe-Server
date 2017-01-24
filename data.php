
<?php
/*
    CallMe-Server: It's a software for sending callback requests from web sites
    
    file: data.php

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


// ERROR CODES 
// 0- ok
// 1- name not set
// 2- phone not set
// 
// 100 - captha missmatch
// 
// -1 - various script errors 


include 'config.php';

$CFG=new callMeConfig(); 

$name=$_POST['name'];
$phone=$_POST['phone'];
$captha=$_POST['captcha'];



if($name == null){
    echo '{"result": "1", "descr": "Name not set"}';
    //echo '{descr:"sss"}';
    return 0;
}

if($phone == null){
    echo '{"result": "2","descr":"Phone not set"}';
    return 0;
}

if($_POST['apiVer'] != $CFG->apiVer){
    die('{"result": "-1","descr":"'.$CFG->apiVer .'API version missmatch"}');
}

// phone normalizer ============

    $sPhone=$phone;
    $sPhone = ereg_replace("[^0-9]",'',$sPhone); 
    
    if(strlen($sPhone) < 10){ //city number
        if(strlen($sPhone) == 7){
            $sArea = substr($sPhone, 0,3); 
            $sPrefix = substr($sPhone,3,2); 
            $sNumber = substr($sPhone,5,2); 
            $phone = $sArea."-".$sPrefix."-".$sNumber  ;          
        }
        else{
            $phone=$sPhone;
        }
       
    } 
    else{
        
        if(strlen($sPhone)>10){ // mobile number
            $sPhone = ereg_replace("[+]",'',$sPhone); 
//            $pls=false;
//            if(substr($sPhone, 0,1)=="+"){
//                $pls=true;
//            }
//            
            $sArea = substr($sPhone, 0,1); 
            $sPrefix = substr($sPhone,1,3); 
            $sNumber = substr($sPhone,4,3); 
            $sNumber2 = substr($sPhone,7,4);
//            if(!$pls){
                $phone = $sArea."-".$sPrefix."-".$sNumber."-".$sNumber2;       
//            }
//            else{
//                $phone ="+".$sArea."-".$sPrefix."-".$sNumber."-".$sNumber2;
//            }
                
        }
        else{ // city code + city number
            $sArea = substr($sPhone, 0,3); 
            $sPrefix = substr($sPhone,3,3); 
            $sNumber = substr($sPhone,6,4); 
            $phone = "(".$sArea.")".$sPrefix."-".$sNumber;            
        }
 
    }
//==========================
    
   
    


  $DB=mysql_connect($CFG->db_addr,$CFG->db_user,$CFG->db_password);//("127.0.0.1","root","reiL0ahp");
  if ($DB==false)
    {
     
      die('{"result": "-1","descr":"Server error: Could not connect to '.mysql_error().'"}');
    } 
    
  if(!mysql_select_db($CFG->db_database) )  
   {
          die( '{"result": "-1","descr":"Server error: Select database '.$DB.'  failed"}');
    }
  

  mysql_query ("set names UTF8");//.$dch,$this->Connection

  $date= time(); 
  $status="wait";
  
  

  

  $r=mysql_query("insert into callme (name,phone,status) values('$name','$phone','$status')");
  
  
  
if($r){
    echo '{"result": "0","descr":"ok"}';
}
else{
    echo '{"result": "-1","descr":"Server error: database operation failed"}';
}


