
    <?php
/*
    CallMe-Server: It's a software for sending callback requests from web sites
    
    file: get.php

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
    
    
// requst types
// - all data (1)
// - all in "wait" status and "process" status whos have a same id as current operator (2)
// - all data in "wait" and "process" status starts at XX:XX:XX (3)

    
include 'config.php';    
    
$CFG=new callMeConfig();    
   
if(($_POST['apiVer'] != $CFG->apiVer)){
    die('{"result": "-1","descr":"API version missmatch"}');
}

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

  
  
  $opid=$_POST['operator'];
  

    $r=mysql_query("select * from ops where op_id='$opid'");
  
  if(mysql_num_rows($r) == 0 ){
      die( '{"result": "-1","descr":"Operaion not permited"}');
  }
  
  
  

$q=$_POST["type"];

switch ($q){
    
    case 1:
        
        break; 
    
    case 2:// .../get.php?type=2&operator=Gher734gnnbcD5632HJUKL
        
        
        
        $new=mysql_query("select * from callme where status='wait' or (operator_id='$opid' and status='process') "); // all newest records

        if($new !== false){
            
            $o=array();
            while ($l = mysql_fetch_assoc($new)) {
                $o[]= $l;
            }
            
            
            echo json_encode($o);
        }
        else{
            $rq=mysql_real_escape_string("select * from callme where status='wait' or (operator_id='$opid' and status='process') ");
            echo '{"result": "-1","descr":"Request error","request":"'.$rq.'"}';
        }
            
        
        
        
        break;
    
    case 3:// .../get.php?type=3&at=1653493563
        
        $start=$_POST['at'];
        
        $new=mysql_query("select * from callme where create_date > '$start'"); // all newest records
        $processing=mysql_query("select * from callme where status = 'process'"); // all processed records at now
        $closed=mysql_query("select * from callme where close_date >= '$start'"); // all closed records at now
        
        break;
    
}

