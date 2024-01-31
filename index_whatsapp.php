<?php 

// Нужно вытащить токен в отдельный файл и зашифровать, для примера захаркодил.
$token = "Вставить свой токен";

// Получаем данные с запроса в виде JSON и декодируем
$textLog = file_get_contents("php://input");
$data = json_decode($textLog, true);

// Сообщения для поиска в тексте
$find_message = array(
	"😂",
	"😍",
	"🤩",
	"👍",
	"😢",
	"🔥",
	"❤",
	"😮",
	"👏",
	"круто",
	"шикарно",
	"красиво"
);

// whatsapp
if ($data['messages'][0]['chatType'] == "whatsapp"){

	// Сообщение из чата
	$message_chat = $data['messages'][0]['text'];

	// Если содержится в сообщении, то отправляем реакцию
	if (in_array(mb_strtolower($message_chat), $find_message)) {
	    $authorization = "Authorization: Bearer ".$token;
		$post = array(
			"channelId" => $data['messages'][0]['channelId'],
			"chatType" => "whatsapp",
			"chatId" => $data['messages'][0]['chatId'],
			"text" => "Благодарим Вас за реакции 🙌"
		);

		$ch = curl_init('https://api.wazzup24.com/v3/message');

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post, JSON_UNESCAPED_UNICODE));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$res = curl_exec($ch);
		curl_close($ch);
		  
		$res = json_encode($res, JSON_UNESCAPED_UNICODE);
	};

}

// instagram
if ($data['messages'][0]['chatType'] == "instagram"){

	// Сообщение из чата
	$message_chat = $data['messages'][0]['text'];

	// Если содержится в сообщении, то отправляем реакцию
	if (in_array(mb_strtolower($message_chat), $find_message)) {
	    $authorization = "Authorization: Bearer ".$token;

	    // Проверка сообщения в директ или комментарий
	    if(!$data['messages'][0]['isEcho']){
	    	$post = array(
				"channelId" => $data['messages'][0]['channelId'],
				"chatType" => "instagram",
				"chatId" => $data['messages'][0]['chatId'],
				"text" => "Благодарим Вас за реакции 🙌",
				"refMessageId" => $data['messages'][0]['messageId']
			);
	    } else {
			$post = array(
				"channelId" => $data['messages'][0]['channelId'],
				"chatType" => "instagram",
				"chatId" => $data['messages'][0]['chatId'],
				"text" => "Благодарим Вас за реакции 🙌"
			);
	    };

		$ch = curl_init('https://api.wazzup24.com/v3/message');

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post, JSON_UNESCAPED_UNICODE));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$res = curl_exec($ch);
		curl_close($ch);
		  
		$res = json_encode($res, JSON_UNESCAPED_UNICODE);

	};

}

// Лог просто закоментировал, вдруг пригодится
// file_put_contents("log.txt", json_encode(array($message_chat, $data['messages'][0]['channelId'], $data['messages'][0]['chatId'])));
// file_put_contents("log.txt", $textLog);


?>