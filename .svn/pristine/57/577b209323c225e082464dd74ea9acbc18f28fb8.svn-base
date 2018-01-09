$(function(){
	document.body.addEventListener('touchstart', function () { /* 空函数，解决ios设备active事件不执行 */ });
	
	/*关闭弹出层*/
	$( '.close-dialog,#keyboard .cancle' ).bind( 'touchend' , function() {
        $("#confirm").html("确认支付");
        $("#paystatus").val(0);
		$( this ).closest( 'section' ).hide();
        $("input[type=password]").val('');
		return false;
	});

    $("#regbutton").bind('click',function(){
        var phone = $("#phone").val();
        var code  = $("#code").val();
        if(phone == ''){
            alert('电话号码不能为空');
            return false;
        }
        if(code == ''){
            alert('验证码不能为空');
            return false;
        }
        $("#form1").submit();
    });

    $("#loginbutton").bind('click',function(){
        var phone = $("#phone").val();
        var code  = $("#code").val();
        if(phone == ''){
            alert('电话号码不能为空');
            return false;
        }
        if(code == ''){
            alert('验证码不能为空');
            return false;
        }
        $("#form1").submit();
    });

    $( '.cz,.qx,.gd' ).bind( 'touchend' , function() {//touchend
        var obj = $(this).parent().parent().parent();
        var oid = obj.find(".orderid").html();
        var stid = obj.find(".stid").html();
        $("#oid").val(oid);
        $("#stid").val(stid);

        if($(this).attr("title") == 'cancelVenue'){
            $("#name").html(obj.find('.line-clamp1').html());
            var time = obj.find('.time').html();
            time = time.replace('<font>','&nbsp;&nbsp;');
            time = time.replace('</font>','&nbsp;&nbsp;');
            time = time.replace('<em>','');
            time = time.replace('</em>','');
            $("#time").html(time);
            $( '#cancel_venue' ).show();
            $("#cancelType").val('cancelVenue');
        }else if($(this).attr("title") == 'cancelOrder'){
            $("#name").html(obj.find('.line-clamp1').html());
            var time = obj.find('.time').html();
            time = time.replace('<font>','&nbsp;&nbsp;');
            time = time.replace('</font>','&nbsp;&nbsp;');
            time = time.replace('<em>','');
            time = time.replace('</em>','');
            $("#time").html(time);
            $( '#cancel_venue' ).show();
            $("#cancelType").val('cancelOrder');
        }else if($(this).attr("title") == 'changeVenue'){
            var backtime  = obj.find(".backtime").html();
            var orderdate = obj.find(".orderdate").html();
            var timestamp = Date.parse(new Date());
            timestamp = timestamp + backtime * 1000;
            var timeinfo  = obj.find(".time font").html();
            var times = timeinfo.split('--');
            var datetime = orderdate+times[0];
            datetime = datetime.replace('月','-');
            datetime = datetime.replace('日',' ');
            datetime = Date.parse(new Date(datetime));
            if(timestamp >= datetime){
                var m = backtime / 3600;
                alert("无法改定，请至少提前"+m+"小时以上改定");
                return false;
            }
            $("#change_name").html(obj.find('.line-clamp1').html());
            var time = obj.find('.time').html();
            time = time.replace('<font>','&nbsp;&nbsp;');
            time = time.replace('</font>','&nbsp;&nbsp;');
            time = time.replace('<em>','');
            time = time.replace('</em>','');
            $("#change_time").html(time);
            $( '#change_venue' ).show();
        }
    });

    $("#confirmRefound").bind('touchstart',function(){
        var oid = $("#oid").val();
        var cancelType = $("#cancelType").val();
        if(oid > 0){
            var param = {oid:oid,cancelType:cancelType};
            if(cancelType == 'cancelVenue'){
                var url = '/Mobile/Order/refound';
            }else if(cancelType == 'cancelOrder'){
                var url = '/Mobile/Order/cancelOrder';
            }
            $.ajax({
                url:url,
                type:"post",
                datatype:"json",
                data:param,
                success:function(data){
                    var result = eval("("+data+")");
                    alert(result.msg);
                    if(result.status == 200){
                        window.location.href = '/Mobile/Order/orderList';
                    }
                    $(".close-dialog").closest( 'section' ).hide();
                }
            });
        }
    });

    $("#confirmChange").bind('touchstart',function(){
        var oid  = $("#oid").val();
        var stid = $("#stid").val();
        if(oid > 0){
            window.location.href = '/Mobile/Order/index/oid/'+oid+'/id/'+stid;
            /*$.ajax({
                url:'/Mobile/Order/cancelOrder',
                type:"post",
                datatype:"json",
                data:{oid:oid},
                success:function(data){
                    var result = eval("("+data+")");
                    alert(result.msg);
                    if(result.status == 200){
                        window.location.href = '/Mobile/Order/orderList';
                    }
                    $(".close-dialog").closest( 'section' ).hide();
                }
            });*/
        }
    });


    $('.piao_botton').delegate(".addcart","click",function() {
        var index =  $(this).attr("index");
        var parentObj = $(this).parent();
        var element_id_name = parentObj.attr("id");
        if(parentObj.find("input").length>0){
            $(this).parent().find("input").val(parentObj.find("input").val()*1+1*1);
        }else{
            var movecart = "<div class='movecart shmovecart'><img src='/Public/Front/img/del.png' /></div>";
            var input = "<div  class='piao_inp shpiao_inp'><input type='text' index='"+index+"' value='1' /></div>"
            $(parentObj).find("img").attr('src',"/Public/Front/img/add.png");
            $(this).parent().html(movecart+input+parentObj.html());
        }
        //已选项目修改内容修改
        selectedUPdate($($(parentObj).parent().children("a")[0]).children("div")[0],1,element_id_name);
    });

    $('.piao_botton').delegate(".movecart","click",function() {
        var parentObj = $(this).parent();
        var element_id_name = parentObj.attr("id");
        if(parentObj.find("input").val()==1){
            var obj = parentObj.find("div").last();
            $(obj).find("img").attr('src',"/Public/Front/img/b_add.png");
            $(this).parent().html(obj);
        }else{
            $(this).parent().find("input").val(parentObj.find("input").val()*1-1*1);
        }
        //已选项目修改内容修改
        selectedUPdate($($(parentObj).parent().children("a")[0]).children("div")[0],-1,element_id_name);
    });

    $('#selected').delegate(".addcart","click",function() {
        var parentObj = $(this).parent();
        var price =  parentObj.parent().find("p").attr("price");
        var num = parentObj.find("input").val();
        parentObj.find("input").val(num*1+1*1);
        $(parentObj).parent().find("em").html("￥"+(price*(num*1+1*1)));

        var element_id_name = $(this).attr("att");
        $("#"+element_id_name).find("input").val(num*1+1*1);

        var total_fee = $("#total_fee").find("em").html();
        total_fee = total_fee.substr(0,total_fee.length-1);
        $("#total_fee").find("em").html((total_fee*1+price*1)+"元");
    });

    $('#selected').delegate(".movecart","click",function() {
        var parentObj = $(this).parent();
        var price =  parentObj.parent().find("p").attr("price");
        var num = parentObj.find("input").val();
        parentObj.find("input").val(num*1-1*1);
        $(parentObj).parent().find("em").html("￥"+(price*(num*1-1*1)));

        var element_id_name = $(this).attr("att");
        $("#"+element_id_name).find("input").val(num*1-1*1);

        var total_fee = $("#total_fee").find("em").html();
        total_fee = total_fee.substr(0,total_fee.length-1);
        $("#total_fee").find("em").html((total_fee*1-price*1)+"元");

        if(num==1){
            parentObj.parent().remove();
            var selectNum = $(".cart_num").find("span").html();
            $(".cart_num").find("span").html(selectNum*1-1*1);
            if(selectNum==2){
                $("#selected").height("52px");
            }else if(selectNum==1){
                $("#selected").parent().hide();
            }

            var obj = $("#"+element_id_name).find("div").last();
            $(obj).find("img").attr('src',"/Public/Front/img/b_add.png");
            $("#"+element_id_name).html(obj);
        }
    });


    $('.piao_botton2').delegate(".addcart","click",function() {
        var index =  $(this).attr("index");
        var parentObj = $(this).parent();
        var element_id_name = parentObj.attr("id");
        var obj = $(parentObj).parent().children("div")[0];
        var price = $($($(obj).children("div")[2]).children("p")[0]).html();
        if(parentObj.find("input").length>0){
            $(this).parent().find("input").val(parentObj.find("input").val()*1+1*1);
        }else{
            $(this).parent().width("145px");
            var movecart = "<div class='movecart'><img src='/Public/Front/img/del.png' /></div>";
            var input = "<div  class='piao_inp notepiao_inp'><input type='text' index='"+index+"' value='1' /></div>"
            $(parentObj).find("img").attr('src',"/Public/Front/img/add.png");
            $(this).parent().html(movecart+input+parentObj.html());
            var selectNum = $(".cart_num").find("span").html();
            $(".cart_num").find("span").html(selectNum*1+1*1);
        }
        /*var total_fee = $("#total_fee").find("em").html();
        total_fee = total_fee.substr(0,total_fee.length-1);
        console.log(total_fee);
        console.log(price);
        console.log(total_fee*1+price*1);

        total_fee = total_fee * 1 + price * 1;
        $("#total_fee").find("em").html(total_fee+"元");*/


        //selectedUPdate($($(parentObj).parent().children("a")[0]).children("div")[0],1,element_id_name);
        selectedUPdate($(parentObj).parent().children("div")[0],1,element_id_name);
    });

    $('.piao_botton2').delegate(".movecart","click",function() {
        var parentObj = $(this).parent();
        var obj1 = $(parentObj).parent().children("div")[0];
        var price = $($($(obj1).children("div")[2]).children("p")[0]).html();
        if(parentObj.find("input").val()==1){
            $(this).parent().width("30px");
            var obj = parentObj.find("div").last();
            $(obj).find("img").attr('src',"/Public/Front/img/b_add.png");
            $(this).parent().html(obj);
            var selectNum = $(".cart_num").find("span").html();
            $(".cart_num").find("span").html(selectNum*1-1*1);
        }else{
            $(this).parent().find("input").val(parentObj.find("input").val()*1-1*1);
        }

        var total_fee = $("#total_fee").find("em").html();
        total_fee = total_fee.substr(0,total_fee.length-1);
        $("#total_fee").find("em").html((total_fee*1-price*1)+"元");
        //已选项目修改内容修改
        //selectedUPdate($(parentObj).parent().children("div")[0],-1,element_id_name);
    });


    //散票购买页确认购票
    $(".submit").bind('click',function(){//touchstart
        var ids = '';
        $("#selected li").each(function(){
            var se_id = $(this).attr('id');
            var sid   = se_id.split("_")[1];
            var num   = $(this).find("input").val();
            ids += '|'+sid+'_'+num;
        });
        if(ids == ''){
            alert('请先选择票务');
            return false;
        }
        ids          = ids.substring(1);
        var param    = {ids:ids};
        $.ajax({
            url:'/Mobile/Order/preTicketOrder',
            type:'post',
            datatype:'json',
            data:param,
            success:function(data){
                var result = eval("("+data+")");
                if(result.status == 0){
                    window.location.href = '/index.php/Mobile/Order/confirm/?type=ticket';
                }else if(result.status == 1){
                    window.location.href = '/Mobile/Userinfo/login';
                }else if(result.status == 3){
                    //window.location.href = '{:U("/Mobile/Order/index")}';
                    alert(result.msg);
                    window.location.reload();
                }else{
                    alert(result.msg);
                }
            }
        });
    });


    //首页搜索体育馆
    $(".search-gy").keyup(function(event){
        if(event.keyCode ==13){
            loadGym();
        }
    });

    $(".cityselect").bind('change',function(){
        loadGym();
    });

    geolocation_latlng();
});

function loadGym(){
    var city = $(".cityselect").val();
    var gymname = $(".search-gy").val();
    if(gymname != null){
        var param = {city:city,gym:gymname};
        $.ajax({
            url:'/index.php/Mobile/Index/searchGym',
            type:'post',
            datatype:'json',
            data:param,
            success:function(data){
                var result = eval('('+data+')');
                if(result.status == 1){
                    var list = '';
                    $(result.list).each(function(i,item){
                        var gymlisttmp = $("#gymlisttmp").html();
                        gymlisttmp = gymlisttmp.replace('{id}',item.id);
                        gymlisttmp = gymlisttmp.replace('{logo}',item.logo);
                        gymlisttmp = gymlisttmp.replace('{name}',item.name);
                        gymlisttmp = gymlisttmp.replace('{city}',item.city);
                        gymlisttmp = gymlisttmp.replace('{area}',item.area);
                        gymlisttmp = gymlisttmp.replace('{address}',item.address);
                        list += gymlisttmp;
                    });
                    $("#gymlist").html(list);
                }else{
                    $("#gymlist").html('<div style="text-align: center; padding-top: 30px;">暂无</div>');
                }
            }
        });
    }
}

function selectedUPdate(obj,addNum,element_id_name){
    var index =  $(obj).attr("index");
    var li_id = $(obj).attr('id');
    var id    = li_id.split("_")[1];
    var text = $($($(obj).children("div")[0]).children("p")[0]).html();
    var price = $($($(obj).children("div")[2]).children("p")[0]).html();
    var unit = $($($(obj).children("div")[2]).children("p")[1]).html();
    var existed = 0;
    var selectNum = 0;
    if($("#selected").children("li").length>0){
        $("#selected").children("li").each(function(){
            var t = $(this).find("b").html();
            var se_id = $(this).attr('id');
            var sid   = se_id.split("_")[1];
            if(id == sid){//t.indexOf(text)>-1
                existed = 1;
                var num = $(this).find("input").val()*1+addNum*1;
                if(num==0){
                    this.remove();
                    selectNum--;
                }else{
                    $(this).find("input").val(num);
                    var fee = $(this).find("em").html();
                    fee = fee.substr(1,fee.length);
                    $(this).find("em").html("￥"+(fee*1+price*addNum));
                }
            }
            selectNum++;
        });
    }

    if(existed==0){
        var html="<li id='se_"+id+"'><p price='"+price+"'> <b>"+text+"</b></p><em style='float:left;'>￥"+(price*addNum)+"</em>";
        html+="<div style='float:right; margin-right:10px;' class='piao_botton'>";
        html+="<div class='movecart' att='"+element_id_name+"'><img src='/Public/Front/img/del.png'></div>";
        html+="<div class='piao_inp'><input type='text' value='"+addNum+"'></div>";
        html+="<div class='addcart' att='"+element_id_name+"'><img src='/Public/Front/img/add.png'></div>";
        html+="</div></li>";

        $("#selected").prepend(html);
        selectNum++;

    }
    if(selectNum>0){
        $("#selected").parent().show();
        if(selectNum>1){
            $("#selected").height("104px");
        }else{
            $("#selected").height("52px");
        }
    }else{
        $("#selected").parent().hide();
    }
    $(".cart_num").find("span").html(selectNum);
    var total_fee = $("#total_fee").find("em").html();
    total_fee = total_fee.substr(0,total_fee.length-1);
    var amount = total_fee * 1 + price * addNum;
    $("#total_fee").find("em").html(amount+"元");
}


/* 倒计时 */
function settime( time ,type) {
    var phone = $("#phone").val();
    if(phone == ''){
        alert('手机号码不能为空');
        return;
    }
    $.ajax({
        url:'/Mobile/Userinfo/sendCode',
        type:'post',
        datatype:'json',
        data:{phone:phone,type:type},
        success:function(data){
            var result = eval("("+data+")");
            if(result.status == 200){
                var btn = $(".sentcode");
                btn.attr("disabled", true);  //按钮禁止点击
                btn.val(time <= 0 ? "发送验证码" : ("重新发送(" + (time) + ")"));
                var hander = setInterval(function() {
                    if (time <= 0) {
                        clearInterval(hander); //清除倒计时
                        btn.val( "发送验证码" );
                        btn.attr( "style" , "background-color:#45a869;color:#fff;" );
                        btn.attr("disabled", false);
                        return false;
                    }else {
                        btn.val("重新发送(" + (time--) + ")");
                        btn.attr( "style" , "background-color:#dedede;color:#6d6e71;" );
                        btn.disabled;
                    }
                }, 1000);
            }else{
                alert(result.msg);
            }
        }
    });

}