
    <?php
/*
    CallMe-Server: It's a software for sending callback requests from web sites
    
    file: set.php

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
    
include 'config.php';    
    
$CFG=new callMeConfig();    
    


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

if($_POST['apiVer'] != $CFG->apiVer){
    die('{"result": "-1","descr":"API version missmatch"}');
}


$q=$_POST["action"]; // process/close
$operator=$_POST['operator'];

$id=$_POST['id'];


  $r=mysql_query("select * from ops where op_id='$operator'");
  
  if(mysql_num_rows($r) == 0 ){
      die( '{"result": "-1","descr":"Operaion not permited"}');
  }



$comment="";
 
if($q == "close"){
    
    $closedate= date("Y-m-d H:i:s",time());   
    
    $comment=$_POST['comment'];
    
    $r=mysql_query("update callme set close_date='$closedate', status='close',call_result='$comment' where  id='$id' and operator_id='$operator' ");
    
    if($r){
        echo '{"result": "0","descr":"ok","status": "close"}';
        return 0;
    }
    else{
        echo '{"result": "-1","descr":"Request error"}';
        return 0;        
    }
}


if($q == "process"){
    
    $r=mysql_query("update callme set status='process', operator_id='$operator'  where   id='$id' and operator_id=' ' ");

    if(mysql_affected_rows()!=0){
        echo '{"result": "0","descr":"ok","status": "process"}';
        return 0;
    }
    else{
        
        $rec=mysql_query("select status from callme where id='$id'");
        
        $resp=mysql_fetch_assoc($rec);
        
        if($resp['status'] == "process"){
            echo '{"result": "1","descr":"Record processed"}';
            return 0;            
        }
        
        if($resp['status'] == "closed"){
            echo '{"result": "2","descr":"Record closed"}';
            return 0;                
        }        
        

    }    
    
}




