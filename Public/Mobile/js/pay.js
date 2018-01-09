function wxpay(){
    var signPackage;
    $.ajax({
        async: false,
        type: "get",
        url: "/Mobile/WeiXin/getJsSign?url=" + encodeURIComponent(location.href),
        dataType: "json",
        cache: false,
        success: function (data) {
            signPackage = (data instanceof Object) ? data : JSON.parse(data);
        }
    });

    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: signPackage.appid, // 必填，公众号的唯一标识
        timestamp: signPackage.timestamp, // 必填，生成签名的时间戳
        nonceStr: signPackage.noncestr, // 必填，生成签名的随机串
        signature: signPackage.signature,// 必填，签名，见附录1
        jsApiList: ['chooseWXPay'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
}

//调用微信JS api 支付
function jsApiCall() {
    var timeStamp   = $("#timeStamp").val();
    var nonceStr    = $("#nonceStr").val();
    var packages    = $("#package").val();
    var paySign     = $("#paySign").val();

    if(packages != ''){
        wx.chooseWXPay({
            timestamp: timeStamp, // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
            nonceStr: nonceStr, // 支付签名随机串，不长于 32 位
            package: packages, // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
            signType: 'MD5', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
            paySign: paySign, // 支付签名
            success: function (res) {// 支付成功后的回调函数
                //window.location.href = '/Mobile/Enroll/index/#enrollinfo';
            },
            cancel:function(res){
            }
        });
    }else{
        alert("请刷新后重试");
    }
}
