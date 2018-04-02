
/**
 *description		 微信配置信息
 *FILE_NAME          wechat
 *author             周天君
 *date               2018/3/29 14:20:48
 */
//echo $_GET['echostr'];
//参考手册：微信开发者文档--介入指南--第二步：验证消息的确来自微信服务器
$signature = $_GET[ "signature" ];
$timestamp = $_GET[ "timestamp" ];
$nonce     = $_GET[ "nonce" ];
$token     = 'wubin';//这里token需要跟微信服务器配置保持一致，自行设置
$tmpArr     = [ $token , $timestamp , $nonce ];
sort ( $tmpArr , SORT_STRING );
$tmpStr = implode ( $tmpArr );
$tmpStr = sha1 ( $tmpStr );

if ( $tmpStr == $signature ) {
echo $_GET['echostr'];exit;
} else {
return false;
}






URL：				http://wechat.houdunphp.cn
Token：				ztj1010
EncodingAESKey：	qDrPKE21VLYq0Ymn0kxjfao5vE6zaO6mOb1qDvcsilw
兼容模式


<!--消息结构-->
SimpleXMLElement::__set_state(array(
'ToUserName' => 'gh_1bbfc33ada53',
'FromUserName' => 'onQSk1OjFUcWDJELWOX65JpbOcJI',
'CreateTime' => '1522313975',
'MsgType' => 'text',
'Content' => '2222',
'MsgId' => '6538288737306040152',
))



SimpleXMLElement::__set_state(array(
'ToUserName' => 'gh_1bbfc33ada53',
'FromUserName' => 'onQSk1OjFUcWDJELWOX65JpbOcJI',
'CreateTime' => '1522338132',
'MsgType' => 'text',
'Content' => '监控',
'MsgId' => '6538392490831020907',
))



<!--批量获取粉丝信息-->
stdClass Object
(
[user_info_list] => Array
(
            [0] => stdClass Object
            (
            [subscribe] => 1
            [openid] => onQSk1OjFUcWDJELWOX65JpbOcJI
            [nickname] => 风华是一指流沙
            [sex] => 0
            [language] => zh_CN
            [city] =>
            [province] =>
            [country] =>
            [headimgurl] => http://thirdwx.qlogo.cn/mmopen/YYm9GuVL6uqiby4ibPycDzJDTjtq93FxQ0RMNJvCkCZTfibpeMdiawJLF9EpY4MtdFJIe2na5Pz30n89TUIA9tZBQTaWxLBGvhUT/132
            [subscribe_time] => 1522411284
            [remark] =>
            [groupid] => 0
            [tagid_list] => Array
            (
            )

            [subscribe_scene] => ADD_SCENE_QR_CODE
            [qr_scene] => 0
            [qr_scene_str] =>
            )

            [1] => stdClass Object
                    (
                    [subscribe] => 1
                    [openid] => onQSk1OjFUcWDJELWOX65JpbOcJI
                    [nickname] => 风华是一指流沙
                    [sex] => 0
                    [language] => zh_CN
                    [city] =>
                    [province] =>
                    [country] =>
                    [headimgurl] => http://thirdwx.qlogo.cn/mmopen/YYm9GuVL6uqiby4ibPycDzJDTjtq93FxQ0RMNJvCkCZTfibpeMdiawJLF9EpY4MtdFJIe2na5Pz30n89TUIA9tZBQTaWxLBGvhUT/132
                    [subscribe_time] => 1522411284
                    [remark] =>
                    [groupid] => 0
                    [tagid_list] => Array
                    (
                    )

                    [subscribe_scene] => ADD_SCENE_QR_CODE
                    [qr_scene] => 0
                    [qr_scene_str] =>
                )

    )

)