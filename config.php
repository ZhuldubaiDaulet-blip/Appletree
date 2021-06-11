<?php
// Setting the correct protocol
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
    $url = 'https://';   
else  
    $url = 'http://';

// Append the host (domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'];   

// The root URL address of the website. Used for 'href' and 'src' attributes of some html tags
$root_url = $url;   
// Root ldp on the server. Used for the 'include_once' functions of PHP
// Note: LDP stands for Local Directory Path
$root_ldp = $_SERVER['DOCUMENT_ROOT'];

// Full URL address (URI) of the page
$url.= $_SERVER['REQUEST_URI']; 

// The connection configuration file LDP
$connection_config = $root_ldp . '/connection_config.php';

// The index webpage URL
$index_url = $root_url . '/index.php';

// Location of the scripts (part of URL)
$js = $root_url . '/scripts' . '/';
// Location of the stylesheets (part of URL)
$css = $root_url . '/stylesheets' . '/';
// Location of the images (part of URL)
$imgs = $root_url . '/images' . '/';

// Location of general (public) pages (URL and LDP)
$general_url = $root_url . '/general' . '/';
$general_ldp = $root_ldp . '/general' . '/';

// Location of the pages for administration (URL and LDP)
$administration_url = $root_url . '/administration' . '/';
$administration_ldp = $root_ldp . '/administration' . '/';

// Location of the pages concerning applications modules / submodules (URL and LDP)
$applications_url = $administration_url . 'applications' . '/';
$applications_ldp = $administration_ldp . 'applications' . '/';

// Location of the pages concerning members modules / submodules (URL and LDP)
$members_url = $administration_url . 'members' . '/';
$members_ldp = $administration_ldp . 'members' . '/';

// Location of the pages concerning classes modules / submodules (URL)
$classes_url = $administration_url . 'classes' . '/';

// Location of the pages concerning schedule modules / submodules (URL)
$schedule_url = $administration_url . 'schedule' . '/';

// Location of the files needed for any kind of processing (URL and LDP)
$processing_url = $root_url . '/processing' . '/';
$processing_ldp = $root_ldp . '/processing' . '/';

// Location of miscellaneous files (URL and LDP)
$miscellaneous_ldp = $root_ldp . '/miscellaneous' . '/';
$miscellaneous_url = $root_url . '/miscellaneous' . '/';

// The LDPs of the headers, footer, 'head' tag, '<-Back' link
$header_ldp = $root_ldp .'/header-footer/header.php';
$headerAdmin_ldp = $root_ldp .'/header-footer/headerAdmin.php';
$footer_ldp = $root_ldp .'/header-footer/footer.php';
$head_ldp = $root_ldp .'/head.php';
$backLink_ldp = $miscellaneous_ldp . 'backLink.php';

// The main administration webpage URL
$adminIndex_url = $administration_url .'admin_index.php';

// The URLs of the injectable php files
$edtInject_url = $administration_url .'frontEdit_injection.php';

$appInject_url = $applications_url .'applications_injection.php';
$appTables_url = $applications_url . 'appTables_injection.php';
$appCvInject_url = $applications_url .'appBrowse_injection.php';

$memCvInject_url = $members_url .'memBrowse_injection.php';
$memInject_url = $members_url . 'members_injection.php';
$memTables_url = $members_url . 'memTables_injection.php';
$memEditInject_url = $members_url . 'memEdit_injection.php';

$clsInject_url = $classes_url .'classes_injection.php';
$clsInfoInject_url = $classes_url . 'clsBrowse_injection.php';
$clsEditInject_url = $classes_url . 'clsEdit_injection.php';

$schInject_url = $schedule_url .'schedule_injection.php';
$schEditInject_url = $schedule_url . 'schEdit_injection.php';
$schStdEdtTbInject_url = $schedule_url . 'schEditTable_injection.php';

// The LDPs of the injectable php files
$appTables_ldp = $applications_ldp . 'appTables_injection.php';
$memTables_ldp = $members_ldp . 'memTables_injection.php';
$memCvInject_ldp = $members_ldp .'memBrowse_injection.php';
$memEditInject_ldp = $members_ldp . 'memEdit_injection.php';
$memTchEdtTbInject_ldp = $members_ldp . 'memEditTablesTch_injection.php';
$memStdEdtTbInject_ldp = $members_ldp . 'memEditTablesStd_injection.php';

// The URLs of the files in 'processing' folder
$router_url = $processing_url . 'admin_routing.php';
$logout_url = $processing_url . 'logout.php';
$appProcessing_url = $processing_url . 'app_processing.php';
$recordProcessing_url = $processing_url . 'record_processing.php';
$cvUpdProcessing_url = $processing_url . 'cvUpdate_processing.php';
$cvDelProcessing_url = $processing_url . 'cvDelete_processing.php';
$classProcessing_url = $processing_url . 'class_processing.php';
$scheduleProcessing_url = $processing_url . 'schedule_processing.php';
$authorizationProcessing_url = $processing_url . 'authorization_processing.php';
$txtUpdProcessing_url = $processing_url . 'texts_processing.php';

// 		Miscellaneous:
// Loader spinner gif image source
$spinner_src = $imgs . "spinner.gif"; 
// Table image-button images' sources
$imgBrw = $imgs.'loupe.png';
$imgAdd = $imgs.'checkmark.png';
$imgDel = $imgs.'xmark.png';
$imgEdt = $imgs.'pencil.png';

// Set the backLink_href according to current page url
switch ($url) {
	case $appMain_url:
		$backLink_href = $index;
		break;
	case $appStd_url:
		$backLink_href = $appMain_url;
		break;
	case $appStdGroup_url:
		$backLink_href = $appStd_url;
		break;
	case $appStdPrivate_url:
		$backLink_href = $appStd_url;
		break;
	case $appTch_url:
		$backLink_href = $appMain_url;
		break;
	default:
		$backLink_href = $index_url;
		break;
}

// Define default exception handler function. The function simply displays the exception.
function exception_handler($exception){
	echo '<b> Exception occured: </b>' . $exception->getMessage().PHP_EOL;
	echo '<br><h1>Please, reload the page or return to <a href='.$index_url.'> Index page </a></h1>';
}
// Set the default exception handler function
set_exception_handler('exception_handler');

// Set some session options
ini_set('session.cookie_httponly',1);
ini_set('session.use_strict_mode',1);
?>