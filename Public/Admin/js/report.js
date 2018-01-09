//缴费统计表
$('.money_search').click(function() {
    var date_s = $('input[name=date_s]').val();
    var date_e = $('input[name=date_e]').val();
    var startLogTimeDate = new Date(Date.parse(date_s.replace(/-/g, "/")));
    var startdate = startLogTimeDate.getDate();
    var starttime = datetime_to_unix(date_s);
    var endtime = datetime_to_unix(date_e);
    var shid = $('#sportHall').val();
    var shtext = $('#sportHall').find("option:selected").text();
    if (date_s == '') {
        alert('请选择开始时间');
        return false;
    }
    if (date_e == '') {
        alert('请选择结束时间')
        return false;
    }
    if (endtime < starttime) {
        alert('结束时间不能早于开始时间');
        return false;
    }
    $.post("moneySum", {date_s: date_s, date_e: date_e, shid: shid}, function(data) {
        var add_tr = '';
        $('#excel2').remove();
        $('#table_box').remove();
        $.each(data.list, function(key, val) {
            add_tr += "<tr><td>" + (startdate + (key)) + "日</td><td>" + val.cash + "</td><td>" + val.weixin + "</td><td >" + val.card + "</td><td >" + val.medicine + "</td><td >" + val.forsuzhou + "</td><td >" + val.suzhoubank + "</td><td >" + val.bohaibank + "</td><td >" + val.transfer + "</td><td >" + val.wxsaoma + "</td><td >" + val.sum + "</td></tr>";
        });

        var table_box = "<input type='button' value='导出' id='excel2' style='float:right;width:50px;margin-bottom:10px;height:30px;margin-right:42%'><table width='650' border='1' align='center' style='margin-top:15px' id='table_box'>" +
                "<tr class='head'>" +
                "<td rowspan='2' width='60'>项目<hr style='transform: rotate(32deg);'>日期</td>" +
                "<td colspan='11' style='font-size:16px;text-align:center'>" + shtext + "<span>(" + date_s + "&nbsp;至&nbsp;" + date_e + ")</span></td>" +
                "</tr>" +
                "<tr><td width='50'>现金</td>" +
                "<td width='50'>微信</td>" +
                "<td width='50'>一卡通</td>" +
                "<td width='50'>医保卡</td>" +
                "<td width='50'>苏州专用</td>" +
                "<td width='50'>苏州银行</td>" +
                "<td width='50'>渤海银行</td>" +
                "<td width='50'>转账</td>" +
				"<td width='50'>微信扫码</td>" +
                "<td width='50'>总计</td>" +
                "</tr>" + add_tr +
                "<tr style='background:#e0e0e0'>" +
                "<td>总计</td><td>" + data.sum.cash + "</td><td>" + data.sum.weixin + "</td><td >" + data.sum.card + "</td><td >" + data.sum.medicine + "</td><td >" + data.sum.forsuzhou + "</td><td >" + data.sum.suzhoubank + "</td><td >" + data.sum.bohaibank + "</td><td >" + data.sum.transfer + "</td><td >" + data.sum.wxsaoma + "</td><td >" + data.sum.sum + "</td></tr></table>";
        $('#search_box').after(table_box);
    });

    $(document).on('click', '#excel2', function() {
        window.location.href = '/Admin/Excel/moneyExcel?start=' + date_s + '&end=' + date_e + '&shid=' + shid;

    });



});


//字符转时间戳
function datetime_to_unix(date) {
    date = new Date(Date.parse(date.replace(/-/g, "/")));
    var timestamp = date.getTime();
    return timestamp;
}


//散票流水       
$('.ticket_search').click(function() {
    var date_s = $('input[name=date_s]').val();
    var date_e = $('input[name=date_e]').val();
    var starttime = datetime_to_unix(date_s);
    var endtime = datetime_to_unix(date_e);
    if (date_s == '') {
        alert('请选择开始时间');
        return false;
    }
    if (date_e == '') {
        alert('请选择结束时间')
        return false;
    }
    if (endtime < starttime) {
        alert('结束时间不能早于开始时间');
        return false;
    }
//catherin 订单流水列表 提供时间段获取相应时间列表
    $.post("/Admin/Report/ticketReport", {date_s: date_s, date_e:date_e}, function(data) {
        $('#table_box').remove();
        $('#moneyReport').remove();
        $('#everyReport').remove();
        var add_tr2 = '';
        var add_tr = '';
        $.each(data.list2, function(key, val) {
            add_tr2 += "<tr>" +
                    "<td colspan='1' width='100'>" + val.title + "</td>" +
                    "<td>" + val.amount + "</td>" +
                    "<td>" + val.count + "</td>" +
                    "<td>" + val.ysamount + "</td>" +
                    "<td>" + val.reduceamount + "</td>" +
                    "<td>" + val.realamount + "</td>" +
                    "<td>" + val.imbalance + "</td>" +
                    "<td>" + val.weixin + "</td>" +
                    "<td>" + val.xianjin + "</td>" +
                    "<td>" + val.yangguang + "</td>" +
                    "<td>" + val.gongshang + "</td>" +
                    "<td>" + val.refundmoney + "</td>" +
                    "<td><a href=/index.php/Admin/Sport/order?sid=" + val.sid + "&date=" + date_s + ">查询</a></td>" +
                    "</tr>";
        });
        $.each(data.list, function(key, val) {
            add_tr += "<tr>" +
                "<td colspan='1' width='100'>" + val.title + "(室外)</td>" +
                "<td>" + val.amount + "</td>" +
                "<td>" + val.count + "</td>" +
                "<td>" + val.ysamount + "</td>" +
                "<td>" + val.reduceamount + "</td>" +
                "<td>" + val.realamount + "</td>" +
                "<td>" + val.imbalance + "</td>" +
                "<td>" + val.weixin + "</td>" +
                "<td>" + val.xianjin + "</td>" +
                "<td>" + val.yangguang + "</td>" +
                "<td>" + val.gongshang + "</td>" +
                "<td>" + val.refundmoney + "</td>" +
                "<td><a href=/index.php/Admin/Sport/order?sid=" + val.sid + "&date=" + date_s + ">查询</a></td>" +
                "</tr>";
        });
        var table_box = ""+
        "<input type='button' value='统计表' id='everyReport' style='float:right;width:50px;margin-bottom:20px;height:30px;margin-right:12%'>"+
        "<table width='1080' border='1' align='center' style='margin-top:15px' id='table_box'>" +
                "<tr>" +
                "<td colspan='1' width='100'>类别</td>" +
                " <td width='50'>单价</td>" +
                " <td width='50'>人数</td>" +
                " <td width='50'>应收</td>" +
                " <td width='50'>优惠</td>" +
                "<td width='50'>实收</td>" +
                "<td width='50'>差价</td>" +
                "<td width='50'>微信</td>" +
                "<td width='50'>现金</td>" +
                " <td width='50'>阳光卡</td>" +
                " <td width='50'>工商银行</td>" +
                 " <td width='50'>微信退款</td>" +
                "<td width='50'></td>" +
                " </tr>" + add_tr2 + add_tr +
                "<tr style='background:#e0e0e0'>" +
                "<td width='100' colspan='1'>总计</td>" +
                " <td width='50'></td>" +
                " <td width='50'>" + data.allsum.count + "</td>" +
                " <td width='50'>" + data.allsum.ysamount + "</td>" +
                " <td width='50'>" + data.allsum.reduceamount + "</td>" +
                " <td width='50'>" + data.allsum.realamount + "</td>" +
                "<td width='50'>" + data.allsum.imbalance + "</td>" +
                "<td width='50'>" + data.allsum.weixin + "</td>" +
                "<td width='50'>" + data.allsum.xianjin + "</td>" +
                "<td width='50'>" + data.allsum.yangguang + "</td>" +
                " <td width='50'>" + data.allsum.gongshang + "</td>" +
            " <td width='50'>" + data.allsum.refundmoney + "</td>" +
                "<td width='50'></td>" +
                " </tr></table>";

        //console.log(table_box);

        $('#search_box').after(table_box);
    });
    
       $(document).on('click', '#moneyReport', function() {
           window.location.href = '/Admin/Excel/everySales?start=' + date_s+'&end='+date_e;
      });
      
       $(document).on('click', '#everyReport', function() {
        window.location.href = '/Admin/Excel/everySales?start=' + date_s+'&end='+date_e;

      });
});

//场地预订流水
$('.order_search').click(function() {
    var date_s = $('input[name=date_s]').val();
    if (date_s == '') {
        alert('请选择时间');
        return false;
    }
    //var starttime = datetime_to_unix(date_s);
    $.post("orderReport", {date_s: date_s}, function(data) {
        var add_tr = '';
        $('#table_box').remove();

        $.each(data.list, function(key, val) {
            add_tr += "<tr>" +
                    "<td>" + val.sportname + "</td>" +
                    "<td>" + val.cash + "</td>" +
                    "<td>" + val.weixin + "</td>" +
                    "<td>" + val.card + "</td>" +
                    "<td>" + val.medicine + "</td>" +
                    "<td>" + val.forsuzhou + "</td>" +
                    "<td>" + val.suzhoubank + "</td>" +
                    "<td>" + val.bohaibank + "</td>" +
					 "<td>" + val.wxsaoma + "</td>" +
                    "<td>" + val.allsum + "</td>" +
                    "<td><a href=/index.php/Admin/Sport/order?shid=" + val.shid + "&date=" + date_s + ">查询</a></td>" +
                    "</tr>";
        });
        var table_box = "<table width='700' border='1' align='center' style='margin-top:15px' id='table_box'>" +
                "<tr>" +
                "<td>场馆类别</td>" +
                "<td width='60'>现金</td>" +
                "<td width='60'>微信</td>" +
                "<td width='65'>一卡通</td>" +
                " <td width='65'>医保卡</td>" +
                " <td width='82'>苏州专用</td>" +
                "<td width='82'>苏州银行</td>" +
                "<td width='82'>渤海银行</td>" +
				 "<td width='82'>微信扫码</td>" +
                "<td width='62'>总计</td>" +
                "<td width='62'></td>" +
                " </tr>" + add_tr +
                "<tr style='background:#e0e0e0'>" +
                "<td>总计</td>" +
                "<td width='50'>" + data.sum.cash + "</td>" +
                "<td width='50'>" + data.sum.weixin + "</td>" +
                "<td width='50'>" + data.sum.card + "</td>" +
                "<td width='50'>" + data.sum.medicine + "</td>" +
                " <td width='55'>" + data.sum.forsuzhou + "</td>" +
                " <td width='62'>" + data.sum.suzhoubank + "</td>" +
                "<td width='62'>" + data.sum.bohaibank + "</td>" +
				 "<td width='62'>" + data.sum.wxsaoma + "</td>" +
                "<td width='62'>" + data.sum.allsum + "</td>" +
                "<td width='62'></td>" +
                " </tr></table>";
        $('#search_box').after(table_box);
    });
});


//日报表
$('.search').click(function() {
    var date_s = $('input[name=date_s]').val();
    var date_e = $('input[name=date_e]').val();
    var startLogTimeDate = new Date(Date.parse(date_s.replace(/-/g, "/")));
    var startdate = startLogTimeDate.getDate();
    console.log(startdate);
    var starttime = datetime_to_unix(date_s);
    var endtime = datetime_to_unix(date_e);
    var shid = $('#sportHall').val();
    var shtext = $('#sportHall').find("option:selected").text();
    if (date_s == '') {
        alert('请选择开始时间');
        return false;
    }
    if (date_e == '') {
        alert('请选择结束时间')
        return false;
    }
    if (endtime < starttime) {
        alert('结束时间不能早于开始时间');
        return false;
    }
    $.post("every", {date_s: date_s, date_e: date_e, shid: shid}, function(data) {
        var add_tr = '';
        $('#excel').remove();
        $('#table_box').remove();
        $.each(data.list, function(key, val) {
            add_tr += "<tr><td >" + (startdate + (key)) + "日</td><td >" + val.open + "</td><td >" + val.fix + "</td>" +
                    "<td >" + val.rent + "</td><td >" + val.activity + "</td>" +
                    "<td >" + val.rent2 + "</td>" +
                    "<td >" + val.ads + "</td>" +
                    "<td >" + val.support + "</td>" +
                    "<td >" + val.others + "</td>" +
                    "<td >" + val.parks + "</td>" +
                    "<td >" + val.sells + "</td>" +
                    "<td >" + val.pays + "</td>" +
                    "<td >" + val.deposit + "</td>" +
                    "<td >" + val.sum + "</td></tr>";
        });

        var table_box = "<input type='button' value='导出' id='excel' style='float:right;width:50px;margin-bottom:10px;height:30px;margin-right:10%'><table width='1050' border='1' align='center' style='margin-top:15px' id='table_box'>" +
                "<tr class='head'>" +
                "<td rowspan='2' width='60'>项目<hr style='transform: rotate(25deg);'>日期</td>" +
                "<td colspan='13' style='font-size:16px;text-align:center'>" + shtext + "<span>(" + date_s + "&nbsp;至&nbsp;" + date_e + ")</span></td>" +
                "</tr>" +
                "<tr><td width='50'>开放</td>" +
                "<td width='50'>固定</td>" +
                "<td width='50'>租场</td>" +
                "<td width='50'>活动</td>" +
                "<td width='50'>租赁</td>" +
                "<td width='50'>广告</td>" +
                "<td width='50'>赞助</td>" +
                "<td width='50'>其他收入</td>" +
                "<td width='50'>停车场</td>" +
                "<td width='50'>小卖部</td>" +
                "<td width='50'>损坏赔偿</td>" +
                "<td width='50'>押金</td>" +
                "<td width='50'>总计</td>" +
                "</tr>" + add_tr +
                "<tr style='background:#e0e0e0'><td>总计</td><td >" + data.sum.open + "</td><td >" + data.sum.fix + "</td>" +
                "<td >" + data.sum.rent + "</td><td >" + data.sum.activity + "</td>" +
                "<td >" + data.sum.rent2 + "</td><td >" + data.sum.ads + "</td>" +
                "<td >" + data.sum.support + "</td><td >" + data.sum.others + "</td>" +
                "<td >" + data.sum.parks + "</td><td >" + data.sum.sells + "</td>" +
                "<td >" + data.sum.pays + "</td><td >" + data.sum.deposit + "</td>" +
                "<td >" + data.sum.countsum + "</td></tr></table>";
        $('#search_box').after(table_box);
    });

    $(document).on('click', '#excel', function() {
        window.location.href = '/Admin/Excel/expExcel?start=' + date_s + '&end=' + date_e + '&shid=' + shid;
    });





});


