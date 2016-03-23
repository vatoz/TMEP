<?php
    include_once 'db.php';
    session_name("tmep");
    session_start();
    if(isset($_REQUEST['zarizeni'])){
        $Zarizeni=intval($_REQUEST['zarizeni']);
        $_SESSION['zarizeni']=$Zarizeni;       
    }elseif(isset($_SESSION['zarizeni'])){
        $Zarizeni=$_SESSION['zarizeni'];    
    }else{
        $Zarizeni=1;    
    }
    
    $q = MySQLi_query($GLOBALS["DBC"], "SELECT * from tme_zarizeni where id=".$Zarizeni);
    $h = MySQLi_fetch_assoc($q);
    
    $GUID = $h['guid'];
    $vlhkomer = $h['vlhkomer'];
    $ip = $h["ip"];
    $umisteni = $h["umisteni"];
    
    define("ZARIZENI",$Zarizeni);
