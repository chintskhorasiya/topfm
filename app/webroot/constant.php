<?php
################################################################
# Define constant for Error message (ADMIN SIDE)
################################################################
//Folder Constant
define("SITE_NAME","Top FM");
define("ADMIN_HEADER_TITLE","Top FM Administrator");
define("SITE_FOLDER","cakephp/topfm");

if(!defined("DEFAULT_URL")) define("DEFAULT_URL","http://".$_SERVER["HTTP_HOST"]."/".SITE_FOLDER."/");

if(!defined("DEFAULT_ADMINURL")) define("DEFAULT_ADMINURL","http://".$_SERVER["HTTP_HOST"]."/".SITE_FOLDER."/admin/");
define("INCLUDE_SITE_ROOT",$_SERVER["DOCUMENT_ROOT"]."/".SITE_FOLDER."/app/webroot/");
define("SITE_ROOT_IMAGE",$_SERVER["DOCUMENT_ROOT"]."/".SITE_FOLDER."/app/webroot/img/");
define("SITE_URL","http://".$_SERVER["HTTP_HOST"]."/".SITE_FOLDER);
define("IMAGE_URL","http://".$_SERVER["HTTP_HOST"]."/".SITE_FOLDER."/img/");
define("STATIC_PAGE_URL","http://".$_SERVER["HTTP_HOST"]."/".SITE_FOLDER."/static/");

define("UPLOAD_FOLDER",SITE_ROOT_IMAGE."uploads/");
define("DISPLAY_URL_IMAGE",IMAGE_URL."uploads/");

//Site constant
define("SITE_TITLE",'Top FM');
define("SITE_EMAIL","chintan@seawindsolution.com");

//Email configuration
define("SITE_TEAM","Top FM Team ");

define("CORRECT_INFO","Please correct given information");

//Footer constant
define('FOOTER_LEFT','&copy '.date('Y').' '.SITE_NAME.' All rights reserved');