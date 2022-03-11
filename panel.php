<?php 

define ("TOKEN", "5104842851:AAEpMxYGegkM2TXcaymQeu5SSYk5iREvbL8");

$input = file_get_contents('php://input');
$update = json_decode($input, true);
// file_put_contents("in.txt", $input);

$text = $update['message']['text'];
$from_id = $update['message']['from']['id'];
$chat_id = $update['message']['chat']['id'];
$channel_id = $update['channel_post']['chat']['id'];
$message_id = $update['message']['message_id'];
$photo = $update['message']['photo'][0]['file_id'];
$video = $update['message']['video']['file_id'];
$caption = $update['message']['caption'];
$first_name = $update['message']['from']['first_name'];
$data = $update['callback_query']['data'];
$call_id = $update['callback_query']['id'];
$user_id = $update['callback_query']['from']['id'];
$mess_id2 = $update['callback_query']['message']['message_id'];

//=====================================
//mysqli_connect('localhost', '#user', '#pass', '#db name');
$db = mysqli_connect('localhost','pixsigms_shoping', 'nv{RnK5(7hC{', 'pixsigms_shop');


//------UTF8----
mysqli_query($db, "SET NAMES 'utf8mb4' ");
mysqli_query($db, "SET CHARACTER SET utf8mb4");
mysqli_query($db, "SET SESSION collation_connection = 'utf8mb4_unicode_ci' ");
//----------
//=====================================
function message($from_id, $text, $key=null, $reply=null){
    $text = urlencode($text);
    $result = file_get_contents("https://api.telegram.org/bot".TOKEN."/sendMessage?chat_id=$from_id&text=$text&parse_mode=html&disable_web_page_preview=1&reply_markup=$key&reply_to_message_id=$reply");
    return $result;
}       // ارسال پیام

function getChat($chat_id, $userid){
    $res = file_get_contents("https:/api.telegram.org/bot".TOKEN."/getChatMember?chat_id=$chat_id&user_id=$userid");
    $res = json_decode($res);
    $member = $res->result->status;
    return $member;
}       // چک کردن جوین بودن یوزر داخل کانال

function photo($chat_id, $photo, $key=null,  $caption=null){
    $result = file_get_contents("https://api.telegram.org/bot".TOKEN."/sendPhoto?chat_id=$chat_id&photo=$photo&caption=$caption&parse_mode=html&disable_web_page_preview=1&reply_markup=$key");
    return $result;
}//ارسال عکس

function forward($chat_id, $from, $message_id){
    return json_decode(file_get_contents("https://api.telegram.org/bot".TOKEN."/forwardMessage?chat_id=$chat_id&from_chat_id=$from&message_id=$message_id"), true);
}       //فوروارد پیام

function video($chat_id, $video, $caption=null, $key=null){
    file_get_contents("https://api.telegram.org/bot".TOKEN."/sendVideo?chat_id=$chat_id&video=$video&caption=$caption&parse_mode=html&disable_web_page_preview=1&reply_markup=$key");
}

function editMess($from_id, $message_id, $text){
    file_get_contents("https://api.telegram.org/bot".TOKEN."/editMessageText?chat_id=$from_id&message_id=$message_id&text=$text");
}

function editMedia($user_id, $mess_id2, $media, $key=null){
    file_get_contents("https://api.telegram.org/bot".TOKEN."/editMessageMedia?chat_id=$user_id&message_id=$mess_id2&media=$media&reply_markup=$key");
}

function copyMessage($chat_id, $from, $message_id){
    file_get_contents("https://api.telegram.org/bot".TOKEN."/copyMessage?chat_id=$chat_id&from_chat_id=$from&message_id=$message_id");
}
//----------------------------------------------

if ($text == "/start"){
    message($from_id, "hello $first_name");
}













?>