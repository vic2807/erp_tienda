<?php

use yii\helpers\Url;
use app\assets\AppAsset;
use app\dgomUtils\menu\RulesMenu;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<style>

    body {
        font-family: "Lato", sans-serif;
    }

    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
        }

    #main {
        transition: margin-left .5s;
        padding: 16px;
    }

        @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
    }
</style>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="menu">
        <?= RulesMenu::getNavBar ()?>
    </div>
</div>
<div id="main">
    
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
</div>
<script>
    function openNav(){
        document.getElementById("mySidenav").style.width="250px";
        document.getElementById("main").style.marginLeft="250px";
    }

    function closeNav(){
        document.getElementById("mySidenav").style.width="0";
        document.getElementById("main").style.marginLeft="0";
    }
</script>