   <?php
/*
    CallMe-Server: It's a software for sending callback requests from web sites
    
    file: createDB.php

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

$ip=$_POST['ip'];
$user=$_POST['user'];
$pass=$_POST['pass'];
$db=$_POST['db'];

  $DB=mysql_connect($ip,$user,$pass);//("127.0.0.1","root","reiL0ahp");
  if ($DB==false)
    {
     
      echo('{"result": "-1","descr":"Server error: '.mysql_error().'"}');
      return;
    } 
    
  if(!mysql_select_db($db) )  
   {
          echo( '{"result": "-1","descr":"Server error: Select database '.$db.'  failed"}');
          return;
    }
    
$templine = '';

$lines = file("./callme.sql");

foreach ($lines as $line){
    
// Skip it if it's a comment
if (substr($line, 0, 2) == '--' || $line == '')
    continue;

// Add this line to the current segment
$templine .= $line;
// If it has a semicolon at the end, it's the end of the query
if (substr(trim($line), -1, 1) == ';')
{
    // Perform the query
    mysql_query($templine) or print('{"result": "-1","descr":" '.$templine . '- ' . mysql_error() .'"}');
    // Reset temp variable to empty
    $templine = '';
}
}    
   // echo('{"result": "0","descr":" '.$templine . '\'- ' . mysql_error() .'"}');

    echo('{"result": "0","descr":"Database structure was created "}');
    return;