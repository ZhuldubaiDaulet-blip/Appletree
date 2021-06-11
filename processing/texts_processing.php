<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php'); 
require_once ($connection_config);

session_start();
// Block access for unathorized users
if (!isset($_SESSION['user_login'])) {
	header("Location:$authorizationPage_url");
}

try {
	// Update each table if new data was posted
	if (isset($_POST['short_texts'])) {
		// Update for every record
		foreach ($_POST['short_texts'] as $recordID => $data) {
			// Filtrate and validate input
			$data['text'] = checkLength(filtrateString( $data['text'] ), 400);
			// Update table record
			$sql = 'UPDATE `appletree_general`.`short_texts` SET `text` = :text WHERE `id` = :id';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([':id' => $recordID, ':text' => $data['text']]);
		}	
	}
	if (isset($_POST['carousel_imgs'])) {
		// Update for every record
		foreach ($_POST['carousel_imgs'] as $recordID => $data) {
			// Filtrate and validate input
			$data['img_file_name'] = checkLength(filtrateString( $data['img_file_name'] ), 100);
	
			$sql = 'UPDATE `appletree_general`.`carousel_imgs` SET `img_file_name` = :img_file_name WHERE `id` = :id';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([':id' => $recordID, ':img_file_name' => $data['img_file_name']]);
		}	
	}
	if (isset($_POST['faqs'])) {
		// Update for every record
		foreach ($_POST['faqs'] as $recordID => $data) {
			// Filtrate and validate input
			$data['question'] = checkLength(filtrateString( $data['question'] ), 255);
			$data['answer'] = checkLength(filtrateString( $data['answer'] ), 650);
	
			$sql = 'UPDATE `appletree_general`.`faqs` SET `question` = :question, `answer` = :answer WHERE `id` = :id';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':id' => $recordID,
				':question' => $data['question'],
				':answer' => $data['answer']]);
		}	
	}
	if (isset($_POST['form_tabs'])) {
		// Update for every record
		foreach ($_POST['form_tabs'] as $recordID => $data) {
			// Filtrate and validate input
			$data['title'] = checkLength(filtrateString( $data['title'] ), 100);
			$data['content'] = checkLength(filtrateString( $data['content'] ), 1000);
	
			$sql = 'UPDATE `appletree_general`.`form_tabs` SET `title` = :title, `content` = :content WHERE `id` = :id';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':id' => $recordID,
				':title' => $data['title'],
				':content' => $data['content']]);
		}	
	}
	if (isset($_POST['social_media'])) {
		// Update for every record
		foreach ($_POST['social_media'] as $recordID => $data) {
			// Filtrate and validate input
			$data['href'] = checkLength(filtrateString( $data['href'] ), 255);
	
			$sql = 'UPDATE `appletree_general`.`social_media` SET `href` = :href WHERE `id` = :id';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([':id' => $recordID, ':href' => $data['href']]);
		}	
	}
	if (isset($_POST['work_schedule'])) {
		// Update for every record
		foreach ($_POST['work_schedule'] as $recordID => $data) {
			// Filtrate and validate input
			$data['working_time'] = checkLength(filtrateString( $data['working_time'] ), 50);
			$data['app_time'] = checkLength(filtrateString( $data['app_time'] ), 50);
	
			$sql = 'UPDATE `appletree_general`.`work_schedule` SET `working_time` = :working_time, `app_time` = :app_time WHERE `id` = :id';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':id' => $recordID,
				':working_time' => $data['working_time'],
				':app_time' => $data['app_time']]);
		}	
	}
	if (isset($_POST['price_list'])) {
		// Update for every record
		foreach ($_POST['price_list'] as $recordID => $data) {
			// Filtrate and validate input
			$data['card_header'] = checkLength(filtrateString( $data['card_header'] ), 50);
			$data['price'] = is_valid(filtrateString( $data['price'] ), '^[0-9]{1,8}$');
			// Check mediumint value constraint
			$data['price'] = ($data['price'] < 16777216)? $data['price'] : is_valid($data['price'],'^0$');
			$data['condition'] = checkLength(filtrateString( $data['condition'] ), 50);
			$data['note'] = checkLength(filtrateString( $data['note'] ), 255);
	
			$sql = 'UPDATE `appletree_general`.`price_list` SET `card_header` = :card_header, `price` = :price, `condition` = :condition, `note` = :note WHERE `id` = :id';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
				':id' => $recordID,
				':card_header' => $data['card_header'],
				':price' => $data['price'],
				':condition' => $data['condition'],
				':note' => $data['note']]);
		}	
	}
} catch (Exception $e) {
	exit($e->getMessage());
}

// The functions below are used to filtrate input strings via encoded fuctions
// and throw corresponting exceptions in case variable is undefined or empty string or does not match required regular expression or exceeds string lenght limit.
function filtrateString($a_string){
	if (is_null($a_string) || !isset($a_string))
		throw new Exception('Some variables are undefined or null!', 1);
	else
		return htmlspecialchars(trim($a_string));
}
function is_valid($a_string, $reg_ex){
	if (!preg_match('/'.$reg_ex.'/',$a_string))
		throw new Exception('Please fill the fields correctly. Incorrect value - "'.$a_string.'"', 1);
	else
		return $a_string;
}
function checkLength($a_string, $length){
	if (mb_strlen($a_string) > $length)
		throw new Exception('Maximum string length limit exceeded! Exceeded value - "'.$a_string.'"', 1);
	else
		return $a_string;
}
?>