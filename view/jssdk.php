<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JSSDK软件开发工具包</title>
<!--	//在需要调用JS接口的页面引入如下JS文件，（支持https）-->
<!--    步骤二：引入微信JS文件-->
	<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

<!--    引入jq文件-->
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>


	<script>
        // 步骤三：通过config接口注入权限验证配置(通过jssdk类文件来分配变量和方法)
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '<?php echo $appId ?>', // 必填，公众号的唯一标识
            timestamp:'<?php echo $timestamp ?>' , // 必填，生成签名的时间戳
            nonceStr: '<?php echo $nonceStr ?>', // 必填，生成签名的随机串
            signature: '<?php echo $signature; ?>',// 必填，签名
            jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','scanQRCode','chooseImage','getNetworkType'] // 必填，需要使用的JS接口列表
        });

        // 步骤四：通过ready接口处理成功验证
        wx.ready(function(){
            // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。

            //1、分享到朋友圈
            wx.onMenuShareTimeline({
                title: '我是分享接口标题', // 分享标题
                link: 'wechat.houdunphp.cn', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: 'http://wechat.houdunphp.cn/dx.jpg', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                    alert('分享成功')
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                    alert('分享失败')
                }
            });


            //2、分享给朋友
                wx.onMenuShareAppMessage({
                    title: '我是分享朋友的标题', // 分享标题
                    desc: '我是分享朋友的描述', // 分享描述
                    link: 'wechat.houdunphp.cn', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                    imgUrl: 'http://wechat.houdunphp.cn/k.png', // 分享图标
                    type: '', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        alert('分享成功')
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                        alert('分享失败')
                    }
                });
            });




	</script>


    <script>
        //3、微信扫一扫
            function scanQRCode(){
                wx.scanQRCode({
                    needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                    scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                    success: function (res) {
                        var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                    }
                });
            }


            //4、拍照或从手机相册中选图接口
               function chooseImage() {
                   wx.chooseImage({
                       count: 6, // 默认9
                       sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                       sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
                       success: function (res) {
                           var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片

                           var str='';
                           //作业，2018年4月2日22:01:03选择完图片之后将图片显示到页面(each)
                           $.each(localIds,function (k,v) {
                               str+='<img src="'+v+'" alt="" style="width=100px;height=100px;">';
                               //$('#box').append('<img src="'+v+'" alt="" style="width: 100px;height: 100px">')

                           })
                           $('#box').html(str);


                       }
                   });
               }

        // "localIds":
        // //         [
        // //             "wxLocalResource://imageid123456789987654321",
        // //             "wxLocalResource://imageid987654321123456789"
        // //         ]

            //5、获取网络状态接口
                function getNetworkType() {
                    wx.getNetworkType({
                        success: function (res) {
                            var networkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
                        }
                    });
                }
       
    </script>
</head>
<body>
<a href="javascript:;" onclick="scanQRCode()">扫一扫</a>
<br>
<a href="javascript:;" onclick="chooseImage()">拍照</a>
<div id="box"></div>
<br>
<a href="javascript:;" onclick="getNetworkType()">网络状态</a>


</body>
</html>