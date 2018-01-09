<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

class ExcelController extends AdminController {

    public function exportExcel($expTitle, $expCellName, $expTableData) {
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle); //文件名称
        $fileName = $_SESSION['loginAccount'] . date('_YmdHis'); //or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1'); //合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle . '  Export time:' . date('Y-m-d H:i:s'));
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls"); //attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    function expUser() {//导出Excel
        ob_clean();
        $xlsName = "User";
        $xlsCell = array(
            array('id', '账号序列'),
            array('name', '登录账户'),
            array('title', '标题')
        );
        $xlsModel = M('Action');
        $xlsData = $xlsModel->Field('id,name,title')->select();
        $this->exportExcel($xlsName, $xlsCell, $xlsData);
    }

    //日报表导出   
    function expExcel() {
        $start = I("start");
        $end = I("end");
        $shid = I("shid");
        vendor('PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("ctos")
                ->setLastModifiedBy("ctos")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");


        /* foreach(range('A','Z') as $v){
          $excelorder[] = $v;
          }
          foreach(range('A','Z') as $v){
          $excelorder[] = 'A'.$v;
          }

          $sport_hall = M("sportHall")->where("id,name")->select();
          foreach($sport_hall as $v){

          }
          foreach($excelorder as $v){

          } */
        $Report = A("Report");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '羽毛球');
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', '开放');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', '固定');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', '租场');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', '活动');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', '合计');
        $datalist = $Report->getDatalist($start, $end, 2);
        //print_r($datalist );die;
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $date = date('m月d日', strtotime('+' . $j . ' day', strtotime($start)));
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $date);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $v['open']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $v['fix']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $v['rent']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $v['activity']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '合计');
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sum['open']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sum['fix']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sum['rent']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sum['activity']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sum['countsum']);

        $objPHPExcel->getActiveSheet()->setCellValue('G1', '篮球');
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('G2', '开放');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', '固定');
        $objPHPExcel->getActiveSheet()->setCellValue('I2', '租场');
        $objPHPExcel->getActiveSheet()->setCellValue('J2', '活动');
        $objPHPExcel->getActiveSheet()->setCellValue('K2', '合计');
        $datalist = $Report->getDatalist($start, $end, 1);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $v['open']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $v['fix']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $v['rent']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $v['activity']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $sum['open']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $sum['fix']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sum['rent']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $sum['activity']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $sum['countsum']);

        $objPHPExcel->getActiveSheet()->setCellValue('L1', '乒乓球');
        $objPHPExcel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('L2', '开放');
        $objPHPExcel->getActiveSheet()->setCellValue('M2', '固定');
        $objPHPExcel->getActiveSheet()->setCellValue('N2', '租场');
        $objPHPExcel->getActiveSheet()->setCellValue('O2', '活动');
        $objPHPExcel->getActiveSheet()->setCellValue('P2', '合计');
        $datalist = $Report->getDatalist($start, $end, 3);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $v['open']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $v['fix']);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $v['rent']);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $v['activity']);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $sum['open']);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $sum['fix']);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $sum['rent']);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $sum['activity']);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $sum['countsum']);

        $objPHPExcel->getActiveSheet()->setCellValue('Q1', '保龄球馆');
        $objPHPExcel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('Q2', '鞋');
        $objPHPExcel->getActiveSheet()->setCellValue('R2', '开放');
        $objPHPExcel->getActiveSheet()->setCellValue('S2', '固定');
        $objPHPExcel->getActiveSheet()->setCellValue('T2', '租场');
        $objPHPExcel->getActiveSheet()->setCellValue('U2', '活动');
        $objPHPExcel->getActiveSheet()->setCellValue('V2', '合计');
        $datalist = $Report->getDatalist($start, $end, 6);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $v['open']);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $v['fix']);
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $v['rent']);
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $v['activity']);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $sum['open']);
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $sum['fix']);
        $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $sum['rent']);
        $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $sum['activity']);
        $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $sum['countsum']);

        $objPHPExcel->getActiveSheet()->setCellValue('W1', '游泳');
        $objPHPExcel->getActiveSheet()->getStyle('W1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('W2', '开放');
        $objPHPExcel->getActiveSheet()->setCellValue('X2', '健康证');
        $objPHPExcel->getActiveSheet()->setCellValue('Y2', '培训');
        $objPHPExcel->getActiveSheet()->setCellValue('Z2', '卡');
        $objPHPExcel->getActiveSheet()->setCellValue('AA2', '冬泳');
        $objPHPExcel->getActiveSheet()->setCellValue('AB2', '救生员');
        $objPHPExcel->getActiveSheet()->setCellValue('AC2', '租场');
        $objPHPExcel->getActiveSheet()->setCellValue('AD2', '活动');
        $objPHPExcel->getActiveSheet()->setCellValue('AE2', '合计');
        $datalist = $Report->getDatalist($start, $end, 4);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $v['open']);
            $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $v['rent']);
            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $v['activity']);
            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $sum['open']);
        $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $sum['rent']);
        $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $sum['activity']);
        $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $sum['countsum']);

        $objPHPExcel->getActiveSheet()->setCellValue('AF1', '足球场');
        $objPHPExcel->getActiveSheet()->getStyle('AF1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('AF2', '开放');
        $objPHPExcel->getActiveSheet()->setCellValue('AG2', '固定');
        $objPHPExcel->getActiveSheet()->setCellValue('AH2', '租场');
        $objPHPExcel->getActiveSheet()->setCellValue('AI2', '活动');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ2', '合计');
        $datalist = $Report->getDatalist($start, $end, 5);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $v['open']);
            $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, $v['fix']);
            $objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, $v['rent']);
            $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, $v['activity']);
            $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $sum['open']);
        $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, $sum['fix']);
        $objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, $sum['rent']);
        $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, $sum['activity']);
        $objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, $sum['countsum']);


        $objPHPExcel->getActiveSheet()->setCellValue('AK1', '租赁');
        $objPHPExcel->getActiveSheet()->setCellValue('AL1', '广告');
        $objPHPExcel->getActiveSheet()->setCellValue('AM1', '赞助');
        $objPHPExcel->getActiveSheet()->setCellValue('AN1', '停车场');
        $objPHPExcel->getActiveSheet()->setCellValue('AO1', '小卖部');
        $objPHPExcel->getActiveSheet()->setCellValue('AP1', '损坏赔偿');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ1', '押金');
        $objPHPExcel->getActiveSheet()->setCellValue('AR1', '其他收入');
        $objPHPExcel->getActiveSheet()->setCellValue('AS1', '汇总');
        $datalist = $Report->getDatalist($start, $end);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, $v['rent2']);
            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, $v['ads']);
            $objPHPExcel->getActiveSheet()->setCellValue('AM' . $i, $v['support']);
            $objPHPExcel->getActiveSheet()->setCellValue('AN' . $i, $v['parks']);
            $objPHPExcel->getActiveSheet()->setCellValue('AO' . $i, $v['sells']);
            $objPHPExcel->getActiveSheet()->setCellValue('AP' . $i, $v['pays']);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $i, $v['deposit']);
            $objPHPExcel->getActiveSheet()->setCellValue('AR' . $i, $v['other']);
            $objPHPExcel->getActiveSheet()->setCellValue('AS' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, $sum['rent2']);
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, $sum['ads']);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . $i, $sum['support']);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . $i, $sum['parks']);
        $objPHPExcel->getActiveSheet()->setCellValue('AO' . $i, $sum['sells']);
        $objPHPExcel->getActiveSheet()->setCellValue('AP' . $i, $sum['pays']);
        $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $i, $sum['deposit']);
        $objPHPExcel->getActiveSheet()->setCellValue('AR' . $i, $sum['other']);
        $objPHPExcel->getActiveSheet()->setCellValue('AS' . $i, $sum['countsum']);


        $objPHPExcel->getActiveSheet()->setCellValue('A1', '项目');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', '日期');
        //$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
        $objPHPExcel->getActiveSheet()->mergeCells('AK1:AK2');
        $objPHPExcel->getActiveSheet()->mergeCells('AL1:AL2');
        $objPHPExcel->getActiveSheet()->mergeCells('AM1:AM2');
        $objPHPExcel->getActiveSheet()->mergeCells('AN1:AN2');
        $objPHPExcel->getActiveSheet()->mergeCells('AO1:AO2');
        $objPHPExcel->getActiveSheet()->mergeCells('AP1:AP2');
        $objPHPExcel->getActiveSheet()->mergeCells('AQ1:AQ2');
        $objPHPExcel->getActiveSheet()->mergeCells('AR1:AR2');
        $objPHPExcel->getActiveSheet()->mergeCells('AS1:AS2');
        $objPHPExcel->getActiveSheet()->getStyle('AK1:AS2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:F1');
        $objPHPExcel->getActiveSheet()->mergeCells('G1:K1');
        $objPHPExcel->getActiveSheet()->mergeCells('L1:P1');
        $objPHPExcel->getActiveSheet()->mergeCells('Q1:V1');
        $objPHPExcel->getActiveSheet()->mergeCells('W1:AE1');
        $objPHPExcel->getActiveSheet()->mergeCells('AF1:AJ1');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN, //细边框
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:AS' . $i)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AS' . $i)->getFont()->setName('宋体');

        /* if($start && $end){
          $Report = A("Report");
          if($shid == 0){
          $sport_hall = M("sportHall")->where("id,name")->order("id asc")->select();
          foreach($sport_hall as $v){
          $datalist = $Report->getDatalist($start, $end, $v['id']);
          $i = 3;
          foreach($datalist['list'] as $vv){
          $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $start);
          $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $vv['open']);
          $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $vv['fix']);
          $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $vv['rent']);
          $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $vv['activity']);
          $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $vv['sum']);
          $i++;
          }
          }
          }else{
          $datalist = $Report->getDatalist($start, $end, $shid);
          $i = 3;
          $j = 0;
          foreach($datalist['list'] as $v){
          $date = date('m月d日',strtotime('+'.$j.' day',strtotime($start)));
          $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $date);
          $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $v['open']);
          $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $v['fix']);
          $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $v['rent']);
          $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $v['activity']);
          $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $v['sum']);
          $i++;
          $j++;
          }
          }
          } */


        ob_end_clean(); //清除缓冲区,避免乱码
        header('pragma:public');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="日报表(' . date('m月d日', strtotime($start)) . '-' . date('m月d日', strtotime($end)) . ').xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    //缴费统计表导出   
    function moneyExcel() {
        $start = I("start");
        $end = I("end");
        $shid = I("shid");
        vendor('PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("ctos")
                ->setLastModifiedBy("ctos")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        $Report = A("Report");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '羽毛球');
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('B2', '现金');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', '微信');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', '一卡通');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', '医保卡');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', '苏州专用');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', '苏州银行');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', '渤海银行');
		$objPHPExcel->getActiveSheet()->setCellValue('I2', '微信扫码');
        $objPHPExcel->getActiveSheet()->setCellValue('J2', '合计');
        $datalist = $Report->getMoneyReport($start, $end, 2);
        //print_r($datalist);die;
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $date = date('m月d日', strtotime('+' . $j . ' day', strtotime($start)));
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $date);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $v['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $v['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $v['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $v['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $v['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $v['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $v['bohaibank']);
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $v['wxsaoma']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $v['sum']);
            $i++;
            $j++;
        }
        //  print_r($date);die;
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, '合计');
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sum['cash']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sum['weixin']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sum['card']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sum['medicine']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $sum['forsuzhou']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $sum['suzhoubank']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $sum['bohaibank']);
		$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $sum['wxsaoma']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $sum['sum']);



        $objPHPExcel->getActiveSheet()->setCellValue('K1', '篮球');
        $objPHPExcel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('K2', '现金');
        $objPHPExcel->getActiveSheet()->setCellValue('L2', '微信');
        $objPHPExcel->getActiveSheet()->setCellValue('M2', '一卡通');
        $objPHPExcel->getActiveSheet()->setCellValue('N2', '医保卡');
        $objPHPExcel->getActiveSheet()->setCellValue('O2', '苏州专用');
        $objPHPExcel->getActiveSheet()->setCellValue('P2', '苏州银行');
        $objPHPExcel->getActiveSheet()->setCellValue('Q2', '渤海银行');
		 $objPHPExcel->getActiveSheet()->setCellValue('R2', '微信扫码');
        $objPHPExcel->getActiveSheet()->setCellValue('S2', '合计');
        $datalist = $Report->getMoneyReport($start, $end, 1);
        //print_r($datalist);die;
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $v['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $v['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $v['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $v['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $v['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $v['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $v['bohaibank']);
			 $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $v['wxsaoma']);
            $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $sum['cash']);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $sum['weixin']);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $sum['card']);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $sum['medicine']);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $sum['forsuzhou']);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $sum['suzhoubank']);
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $sum['bohaibank']);
		$objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $sum['wxsaoma']);
        $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $sum['sum']);




        $objPHPExcel->getActiveSheet()->setCellValue('T1', '乒乓球');
        $objPHPExcel->getActiveSheet()->getStyle('T1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('T2', '现金');
        $objPHPExcel->getActiveSheet()->setCellValue('U2', '微信');
        $objPHPExcel->getActiveSheet()->setCellValue('V2', '一卡通');
        $objPHPExcel->getActiveSheet()->setCellValue('W2', '医保卡');
        $objPHPExcel->getActiveSheet()->setCellValue('X2', '苏州专用');
        $objPHPExcel->getActiveSheet()->setCellValue('Y2', '苏州银行');
        $objPHPExcel->getActiveSheet()->setCellValue('Z2', '渤海银行');
		$objPHPExcel->getActiveSheet()->setCellValue('AA2', '微信扫码');
        $objPHPExcel->getActiveSheet()->setCellValue('AB2', '合计');
        $datalist = $Report->getMoneyReport($start, $end, 3);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $v['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $v['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $v['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $v['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $v['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $v['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $v['bohaibank']);
			 $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $v['wxsaoma']);
            $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $sum['cash']);
        $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $sum['weixin']);
        $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $sum['card']);
        $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $sum['medicine']);
        $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $sum['forsuzhou']);
        $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $sum['suzhoubank']);
        $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $sum['bohaibank']);
		 $objPHPExcel->getActiveSheet()->setCellValue('AA' . $i, $sum['wxsaoma']);
        $objPHPExcel->getActiveSheet()->setCellValue('AB' . $i, $sum['sum']);






        $objPHPExcel->getActiveSheet()->setCellValue('AC1', '保龄球馆');
        $objPHPExcel->getActiveSheet()->getStyle('AC1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('AC2', '现金');
        $objPHPExcel->getActiveSheet()->setCellValue('AD2', '微信');
        $objPHPExcel->getActiveSheet()->setCellValue('AE2', '一卡通');
        $objPHPExcel->getActiveSheet()->setCellValue('AF2', '医保卡');
        $objPHPExcel->getActiveSheet()->setCellValue('AG2', '苏州专用');
        $objPHPExcel->getActiveSheet()->setCellValue('AH2', '苏州银行');
        $objPHPExcel->getActiveSheet()->setCellValue('AI2', '渤海银行');
		$objPHPExcel->getActiveSheet()->setCellValue('AJ2', '微信扫码');
        $objPHPExcel->getActiveSheet()->setCellValue('AK2', '合计');
        $datalist = $Report->getMoneyReport($start, $end, 6);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $v['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $v['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $v['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $v['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, $v['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, $v['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, $v['bohaibank']);
			$objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, $v['wxsaoma']);
            $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('AC' . $i, $sum['cash']);
        $objPHPExcel->getActiveSheet()->setCellValue('AD' . $i, $sum['weixin']);
        $objPHPExcel->getActiveSheet()->setCellValue('AE' . $i, $sum['card']);
        $objPHPExcel->getActiveSheet()->setCellValue('AF' . $i, $sum['medicine']);
        $objPHPExcel->getActiveSheet()->setCellValue('AG' . $i, $sum['forsuzhou']);
        $objPHPExcel->getActiveSheet()->setCellValue('AH' . $i, $sum['suzhoubank']);
        $objPHPExcel->getActiveSheet()->setCellValue('AI' . $i, $sum['bohaibank']);
		$objPHPExcel->getActiveSheet()->setCellValue('AJ' . $i, $sum['wxsaoma']);
        $objPHPExcel->getActiveSheet()->setCellValue('AK' . $i, $sum['sum']);



        $objPHPExcel->getActiveSheet()->setCellValue('AL1', '游泳');
        $objPHPExcel->getActiveSheet()->getStyle('AL1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('AL2', '现金');
        $objPHPExcel->getActiveSheet()->setCellValue('AM2', '微信');
        $objPHPExcel->getActiveSheet()->setCellValue('AN2', '一卡通');
        $objPHPExcel->getActiveSheet()->setCellValue('AO2', '医保卡');
        $objPHPExcel->getActiveSheet()->setCellValue('AP2', '苏州专用');
        $objPHPExcel->getActiveSheet()->setCellValue('AQ2', '苏州银行');
        $objPHPExcel->getActiveSheet()->setCellValue('AR2', '渤海银行');
	    $objPHPExcel->getActiveSheet()->setCellValue('AS2', '微信扫码');
        $objPHPExcel->getActiveSheet()->setCellValue('AT2', '合计');
        $datalist = $Report->getMoneyReport($start, $end, 4);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, $v['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('AM' . $i, $v['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('AN' . $i, $v['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('AO' . $i, $v['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('AP' . $i, $v['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $i, $v['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('AR' . $i, $v['bohaibank']);
			$objPHPExcel->getActiveSheet()->setCellValue('AS' . $i, $v['wxsaoma']);
            $objPHPExcel->getActiveSheet()->setCellValue('AT' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('AL' . $i, $sum['cash']);
        $objPHPExcel->getActiveSheet()->setCellValue('AM' . $i, $sum['weixin']);
        $objPHPExcel->getActiveSheet()->setCellValue('AN' . $i, $sum['card']);
        $objPHPExcel->getActiveSheet()->setCellValue('AO' . $i, $sum['medicine']);
        $objPHPExcel->getActiveSheet()->setCellValue('AP' . $i, $sum['forsuzhou']);
        $objPHPExcel->getActiveSheet()->setCellValue('AQ' . $i, $sum['suzhoubank']);
        $objPHPExcel->getActiveSheet()->setCellValue('AR' . $i, $sum['bohaibank']);
		$objPHPExcel->getActiveSheet()->setCellValue('AS' . $i, $sum['wxsaoma']);
        $objPHPExcel->getActiveSheet()->setCellValue('AT' . $i, $sum['sum']);




        $objPHPExcel->getActiveSheet()->setCellValue('AU1', '足球场');
        $objPHPExcel->getActiveSheet()->getStyle('AU1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('AU2', '现金');
        $objPHPExcel->getActiveSheet()->setCellValue('AV2', '微信');
        $objPHPExcel->getActiveSheet()->setCellValue('AW2', '一卡通');
        $objPHPExcel->getActiveSheet()->setCellValue('AX2', '医保卡');
        $objPHPExcel->getActiveSheet()->setCellValue('AY2', '苏州专用');
        $objPHPExcel->getActiveSheet()->setCellValue('AZ2', '苏州银行');
        $objPHPExcel->getActiveSheet()->setCellValue('BA2', '渤海银行');
		 $objPHPExcel->getActiveSheet()->setCellValue('BB2', '微信扫码');
        $objPHPExcel->getActiveSheet()->setCellValue('BC2', '合计');
        $datalist = $Report->getMoneyReport($start, $end, 5);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('AU' . $i, $v['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('AV' . $i, $v['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('AW' . $i, $v['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('AX' . $i, $v['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('AY' . $i, $v['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('AZ' . $i, $v['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('BA' . $i, $v['bohaibank']);
			$objPHPExcel->getActiveSheet()->setCellValue('BB' . $i, $v['wxsaoma']);
            $objPHPExcel->getActiveSheet()->setCellValue('BC' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('AU' . $i, $sum['cash']);
        $objPHPExcel->getActiveSheet()->setCellValue('AV' . $i, $sum['weixin']);
        $objPHPExcel->getActiveSheet()->setCellValue('AW' . $i, $sum['card']);
        $objPHPExcel->getActiveSheet()->setCellValue('AX' . $i, $sum['medicine']);
        $objPHPExcel->getActiveSheet()->setCellValue('AY' . $i, $sum['forsuzhou']);
        $objPHPExcel->getActiveSheet()->setCellValue('AZ' . $i, $sum['suzhoubank']);
        $objPHPExcel->getActiveSheet()->setCellValue('BA' . $i, $sum['bohaibank']);
		 $objPHPExcel->getActiveSheet()->setCellValue('BB' . $i, $sum['wxsaoma']);
        $objPHPExcel->getActiveSheet()->setCellValue('BC' . $i, $sum['sum']);

        if ($shid == 0) {
            $objPHPExcel->getActiveSheet()->setCellValue('BD1', '租赁');
            $objPHPExcel->getActiveSheet()->getStyle('BD1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue('BD2', '现金');
            $objPHPExcel->getActiveSheet()->setCellValue('BE2', '微信');
            $objPHPExcel->getActiveSheet()->setCellValue('BF2', '一卡通');
            $objPHPExcel->getActiveSheet()->setCellValue('BG2', '医保卡');
            $objPHPExcel->getActiveSheet()->setCellValue('BH2', '苏州专用');
            $objPHPExcel->getActiveSheet()->setCellValue('BI2', '苏州银行');
            $objPHPExcel->getActiveSheet()->setCellValue('BJ2', '渤海银行');
	        $objPHPExcel->getActiveSheet()->setCellValue('BK2', '微信扫码');

            $objPHPExcel->getActiveSheet()->setCellValue('BL2', '合计');
            $datalist = $Report->getOtherMoney($start, $end, '租赁');
            $i = 3;
            $j = 0;
            foreach ($datalist['list'] as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue('BD' . $i, $v['cash']);
                $objPHPExcel->getActiveSheet()->setCellValue('BE' . $i, $v['weixin']);
                $objPHPExcel->getActiveSheet()->setCellValue('BF' . $i, $v['card']);
                $objPHPExcel->getActiveSheet()->setCellValue('BG' . $i, $v['medicine']);
                $objPHPExcel->getActiveSheet()->setCellValue('BH' . $i, $v['forsuzhou']);
                $objPHPExcel->getActiveSheet()->setCellValue('BI' . $i, $v['suzhoubank']);
                $objPHPExcel->getActiveSheet()->setCellValue('BJ' . $i, $v['bohaibank']);
				  $objPHPExcel->getActiveSheet()->setCellValue('BK' . $i, $v['wxsaoma']);
                $objPHPExcel->getActiveSheet()->setCellValue('BL' . $i, $v['sum']);
                $i++;
                $j++;
            }
            $sum = $datalist['sum'];
            $objPHPExcel->getActiveSheet()->setCellValue('BD' . $i, $sum['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('BE' . $i, $sum['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('BF' . $i, $sum['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('BG' . $i, $sum['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('BH' . $i, $sum['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('BI' . $i, $sum['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('BJ' . $i, $sum['bohaibank']);
			$objPHPExcel->getActiveSheet()->setCellValue('BK' . $i, $sum['wxsaoma']);
            $objPHPExcel->getActiveSheet()->setCellValue('BL' . $i, $sum['sum']);


            $objPHPExcel->getActiveSheet()->setCellValue('BM1', '广告');
            $objPHPExcel->getActiveSheet()->getStyle('BM1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue('BM2', '现金');
            $objPHPExcel->getActiveSheet()->setCellValue('BN2', '微信');
            $objPHPExcel->getActiveSheet()->setCellValue('BO2', '一卡通');
            $objPHPExcel->getActiveSheet()->setCellValue('BP2', '医保卡');
            $objPHPExcel->getActiveSheet()->setCellValue('BQ2', '苏州专用');
            $objPHPExcel->getActiveSheet()->setCellValue('BR2', '苏州银行');
            $objPHPExcel->getActiveSheet()->setCellValue('BS2', '渤海银行');
			 $objPHPExcel->getActiveSheet()->setCellValue('BT2', '微信扫码');
            $objPHPExcel->getActiveSheet()->setCellValue('BU2', '合计');
            $datalist = $Report->getOtherMoney($start, $end, '广告');
            $i = 3;
            $j = 0;
            foreach ($datalist['list'] as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue('BM' . $i, $v['cash']);
                $objPHPExcel->getActiveSheet()->setCellValue('BN' . $i, $v['weixin']);
                $objPHPExcel->getActiveSheet()->setCellValue('BO' . $i, $v['card']);
                $objPHPExcel->getActiveSheet()->setCellValue('BP' . $i, $v['medicine']);
                $objPHPExcel->getActiveSheet()->setCellValue('BQ' . $i, $v['forsuzhou']);
                $objPHPExcel->getActiveSheet()->setCellValue('BR' . $i, $v['suzhoubank']);
                $objPHPExcel->getActiveSheet()->setCellValue('BS' . $i, $v['bohaibank']);
				 $objPHPExcel->getActiveSheet()->setCellValue('BT' . $i, $v['wxsaoma']);
                $objPHPExcel->getActiveSheet()->setCellValue('BU' . $i, $v['sum']);
                $i++;
                $j++;
            }
            $sum = $datalist['sum'];
            $objPHPExcel->getActiveSheet()->setCellValue('BM' . $i, $sum['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('BN' . $i, $sum['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('BO' . $i, $sum['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('BP' . $i, $sum['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('BQ' . $i, $sum['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('BR' . $i, $sum['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('BS' . $i, $sum['bohaibank']);
			$objPHPExcel->getActiveSheet()->setCellValue('BT' . $i, $sum['wxsaoma']);
            $objPHPExcel->getActiveSheet()->setCellValue('BU' . $i, $sum['sum']);


            $objPHPExcel->getActiveSheet()->setCellValue('BV1', '赞助');
            $objPHPExcel->getActiveSheet()->getStyle('BV1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue('BV2', '现金');
            $objPHPExcel->getActiveSheet()->setCellValue('BW2', '微信');
            $objPHPExcel->getActiveSheet()->setCellValue('BX2', '一卡通');
            $objPHPExcel->getActiveSheet()->setCellValue('BY2', '医保卡');
            $objPHPExcel->getActiveSheet()->setCellValue('BZ2', '苏州专用');
            $objPHPExcel->getActiveSheet()->setCellValue('CA2', '苏州银行');
            $objPHPExcel->getActiveSheet()->setCellValue('CB2', '渤海银行');
			 $objPHPExcel->getActiveSheet()->setCellValue('CC2', '微信扫码');
            $objPHPExcel->getActiveSheet()->setCellValue('CD2', '合计');
            $datalist = $Report->getOtherMoney($start, $end, '赞助');
            $i = 3;
            $j = 0;
            foreach ($datalist['list'] as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue('BV' . $i, $v['cash']);
                $objPHPExcel->getActiveSheet()->setCellValue('BW' . $i, $v['weixin']);
                $objPHPExcel->getActiveSheet()->setCellValue('BX' . $i, $v['card']);
                $objPHPExcel->getActiveSheet()->setCellValue('BY' . $i, $v['medicine']);
                $objPHPExcel->getActiveSheet()->setCellValue('BZ' . $i, $v['forsuzhou']);
                $objPHPExcel->getActiveSheet()->setCellValue('CA' . $i, $v['suzhoubank']);
                $objPHPExcel->getActiveSheet()->setCellValue('CB' . $i, $v['bohaibank']);
				 $objPHPExcel->getActiveSheet()->setCellValue('CC' . $i, $v['wxsaoma']);
                $objPHPExcel->getActiveSheet()->setCellValue('CD' . $i, $v['sum']);
                $i++;
                $j++;
            }
            $sum = $datalist['sum'];
            $objPHPExcel->getActiveSheet()->setCellValue('BV' . $i, $sum['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('BW' . $i, $sum['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('BX' . $i, $sum['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('BY' . $i, $sum['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('BZ' . $i, $sum['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('CA' . $i, $sum['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('CB' . $i, $sum['bohaibank']);
			$objPHPExcel->getActiveSheet()->setCellValue('CC' . $i, $sum['wxsaoma']);
            $objPHPExcel->getActiveSheet()->setCellValue('CD' . $i, $sum['sum']);


            $objPHPExcel->getActiveSheet()->setCellValue('CE1', '其他收入');
            $objPHPExcel->getActiveSheet()->getStyle('CE1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue('CE2', '现金');
            $objPHPExcel->getActiveSheet()->setCellValue('CF2', '微信');
            $objPHPExcel->getActiveSheet()->setCellValue('CG2', '一卡通');
            $objPHPExcel->getActiveSheet()->setCellValue('CH2', '医保卡');
            $objPHPExcel->getActiveSheet()->setCellValue('CI2', '苏州专用');
            $objPHPExcel->getActiveSheet()->setCellValue('CJ2', '苏州银行');
            $objPHPExcel->getActiveSheet()->setCellValue('CK2', '渤海银行');
			$objPHPExcel->getActiveSheet()->setCellValue('CL2', '微信扫码');
            $objPHPExcel->getActiveSheet()->setCellValue('CM2', '合计');
            $datalist = $Report->getOtherMoney($start, $end, '其他收入');
            $i = 3;
            $j = 0;
            foreach ($datalist['list'] as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue('CE' . $i, $v['cash']);
                $objPHPExcel->getActiveSheet()->setCellValue('CF' . $i, $v['weixin']);
                $objPHPExcel->getActiveSheet()->setCellValue('CG' . $i, $v['card']);
                $objPHPExcel->getActiveSheet()->setCellValue('CH' . $i, $v['medicine']);
                $objPHPExcel->getActiveSheet()->setCellValue('CI' . $i, $v['forsuzhou']);
                $objPHPExcel->getActiveSheet()->setCellValue('CJ' . $i, $v['suzhoubank']);
                $objPHPExcel->getActiveSheet()->setCellValue('CK' . $i, $v['bohaibank']);
			    $objPHPExcel->getActiveSheet()->setCellValue('CL' . $i, $v['wxsaoma']);
                $objPHPExcel->getActiveSheet()->setCellValue('CM' . $i, $v['sum']);
                $i++;
                $j++;
            }
            $sum = $datalist['sum'];
            $objPHPExcel->getActiveSheet()->setCellValue('CE' . $i, $sum['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('CF' . $i, $sum['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('CG' . $i, $sum['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('CH' . $i, $sum['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('CI' . $i, $sum['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('CJ' . $i, $sum['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('CK' . $i, $sum['bohaibank']);
			$objPHPExcel->getActiveSheet()->setCellValue('CL' . $i, $sum['wxsaoma']);
            $objPHPExcel->getActiveSheet()->setCellValue('CM' . $i, $sum['sum']);


            $objPHPExcel->getActiveSheet()->setCellValue('CN1', '停车场');
            $objPHPExcel->getActiveSheet()->getStyle('CN1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue('CN2', '现金');
            $objPHPExcel->getActiveSheet()->setCellValue('CO2', '微信');
            $objPHPExcel->getActiveSheet()->setCellValue('CP2', '一卡通');
            $objPHPExcel->getActiveSheet()->setCellValue('CQ2', '医保卡');
            $objPHPExcel->getActiveSheet()->setCellValue('CR2', '苏州专用');
            $objPHPExcel->getActiveSheet()->setCellValue('CS2', '苏州银行');
            $objPHPExcel->getActiveSheet()->setCellValue('CT2', '渤海银行');
			$objPHPExcel->getActiveSheet()->setCellValue('CU2', '微信扫码');
            $objPHPExcel->getActiveSheet()->setCellValue('CV2', '合计');
            $datalist = $Report->getOtherMoney($start, $end, '停车场');
            $i = 3;
            $j = 0;
            foreach ($datalist['list'] as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue('CN' . $i, $v['cash']);
                $objPHPExcel->getActiveSheet()->setCellValue('CO' . $i, $v['weixin']);
                $objPHPExcel->getActiveSheet()->setCellValue('CP' . $i, $v['card']);
                $objPHPExcel->getActiveSheet()->setCellValue('CQ' . $i, $v['medicine']);
                $objPHPExcel->getActiveSheet()->setCellValue('CR' . $i, $v['forsuzhou']);
                $objPHPExcel->getActiveSheet()->setCellValue('CS' . $i, $v['suzhoubank']);
                $objPHPExcel->getActiveSheet()->setCellValue('CT' . $i, $v['bohaibank']);
				$objPHPExcel->getActiveSheet()->setCellValue('CU' . $i, $v['wxsaoma']);

                $objPHPExcel->getActiveSheet()->setCellValue('CV' . $i, $v['sum']);
                $i++;
                $j++;
            }
            $sum = $datalist['sum'];
            $objPHPExcel->getActiveSheet()->setCellValue('CN' . $i, $sum['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('CO' . $i, $sum['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('CP' . $i, $sum['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('CQ' . $i, $sum['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('CR' . $i, $sum['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('CS' . $i, $sum['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('CT' . $i, $sum['bohaibank']);
			$objPHPExcel->getActiveSheet()->setCellValue('CU' . $i, $sum['wxsaoma']);

            $objPHPExcel->getActiveSheet()->setCellValue('CV' . $i, $sum['sum']);


            $objPHPExcel->getActiveSheet()->setCellValue('CW1', '小卖部');
            $objPHPExcel->getActiveSheet()->getStyle('CW1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue('CW2', '现金');
            $objPHPExcel->getActiveSheet()->setCellValue('CX2', '微信');
            $objPHPExcel->getActiveSheet()->setCellValue('CY2', '一卡通');
            $objPHPExcel->getActiveSheet()->setCellValue('CZ2', '医保卡');
            $objPHPExcel->getActiveSheet()->setCellValue('DA2', '苏州专用');
            $objPHPExcel->getActiveSheet()->setCellValue('DB2', '苏州银行');
            $objPHPExcel->getActiveSheet()->setCellValue('DC2', '渤海银行');
			$objPHPExcel->getActiveSheet()->setCellValue('DD2', '微信扫码');

            $objPHPExcel->getActiveSheet()->setCellValue('DE2', '合计');
            $datalist = $Report->getOtherMoney($start, $end, '小卖部');
            $i = 3;
            $j = 0;
            foreach ($datalist['list'] as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue('CW' . $i, $v['cash']);
                $objPHPExcel->getActiveSheet()->setCellValue('CX' . $i, $v['weixin']);
                $objPHPExcel->getActiveSheet()->setCellValue('CY' . $i, $v['card']);
                $objPHPExcel->getActiveSheet()->setCellValue('CZ' . $i, $v['medicine']);
                $objPHPExcel->getActiveSheet()->setCellValue('DA' . $i, $v['forsuzhou']);
                $objPHPExcel->getActiveSheet()->setCellValue('DB' . $i, $v['suzhoubank']);
                $objPHPExcel->getActiveSheet()->setCellValue('DC' . $i, $v['bohaibank']);
		        $objPHPExcel->getActiveSheet()->setCellValue('DD' . $i, $v['wxsaoma']);

                $objPHPExcel->getActiveSheet()->setCellValue('DE' . $i, $v['sum']);
                $i++;
                $j++;
            }
            $sum = $datalist['sum'];
            $objPHPExcel->getActiveSheet()->setCellValue('CW' . $i, $sum['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('CX' . $i, $sum['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('CY' . $i, $sum['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('CZ' . $i, $sum['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('DA' . $i, $sum['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('DB' . $i, $sum['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('DC' . $i, $sum['bohaibank']);
			            $objPHPExcel->getActiveSheet()->setCellValue('DD' . $i, $sum['wxsaoma']);

            $objPHPExcel->getActiveSheet()->setCellValue('DE' . $i, $sum['sum']);


            $objPHPExcel->getActiveSheet()->setCellValue('DF1', '损坏赔偿');
            $objPHPExcel->getActiveSheet()->getStyle('DF1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue('DF2', '现金');
            $objPHPExcel->getActiveSheet()->setCellValue('DG2', '微信');
            $objPHPExcel->getActiveSheet()->setCellValue('DH2', '一卡通');
            $objPHPExcel->getActiveSheet()->setCellValue('DI2', '医保卡');
            $objPHPExcel->getActiveSheet()->setCellValue('DJ2', '苏州专用2');
            $objPHPExcel->getActiveSheet()->setCellValue('DK2', '苏州银行');
            $objPHPExcel->getActiveSheet()->setCellValue('DL2', '渤海银行');
			            $objPHPExcel->getActiveSheet()->setCellValue('DM2', '微信扫码');

            $objPHPExcel->getActiveSheet()->setCellValue('DN2', '合计');
            $datalist = $Report->getOtherMoney($start, $end, '损坏赔偿');
            $i = 3;
            $j = 0;
            foreach ($datalist['list'] as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue('DF' . $i, $v['cash']);
                $objPHPExcel->getActiveSheet()->setCellValue('DG' . $i, $v['weixin']);
                $objPHPExcel->getActiveSheet()->setCellValue('DH' . $i, $v['card']);
                $objPHPExcel->getActiveSheet()->setCellValue('DI' . $i, $v['medicine']);
                $objPHPExcel->getActiveSheet()->setCellValue('DJ' . $i, $v['forsuzhou']);
                $objPHPExcel->getActiveSheet()->setCellValue('DK' . $i, $v['suzhoubank']);
                $objPHPExcel->getActiveSheet()->setCellValue('DL' . $i, $v['bohaibank']);
				                $objPHPExcel->getActiveSheet()->setCellValue('DM' . $i, $v['wxsaoma']);

                $objPHPExcel->getActiveSheet()->setCellValue('DN' . $i, $v['sum']);
                $i++;
                $j++;
            }
            $sum = $datalist['sum'];
            $objPHPExcel->getActiveSheet()->setCellValue('DF' . $i, $sum['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('DG' . $i, $sum['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('DH' . $i, $sum['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('DI' . $i, $sum['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('DJ' . $i, $sum['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('DK' . $i, $sum['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('DL' . $i, $sum['bohaibank']);
			            $objPHPExcel->getActiveSheet()->setCellValue('DM' . $i, $sum['wxsaoma']);

            $objPHPExcel->getActiveSheet()->setCellValue('DN' . $i, $sum['sum']);


            $objPHPExcel->getActiveSheet()->setCellValue('DO1', '押金');
            $objPHPExcel->getActiveSheet()->getStyle('DO1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue('DO2', '现金');
            $objPHPExcel->getActiveSheet()->setCellValue('DP2', '微信');
            $objPHPExcel->getActiveSheet()->setCellValue('DQ2', '一卡通');
            $objPHPExcel->getActiveSheet()->setCellValue('DR2', '医保卡');
            $objPHPExcel->getActiveSheet()->setCellValue('DS2', '苏州专用');
            $objPHPExcel->getActiveSheet()->setCellValue('DT2', '苏州银行');
            $objPHPExcel->getActiveSheet()->setCellValue('DU2', '渤海银行');
			            $objPHPExcel->getActiveSheet()->setCellValue('DV2', '微信扫码');

            $objPHPExcel->getActiveSheet()->setCellValue('DW2', '合计');
            $datalist = $Report->getOtherMoney($start, $end, '押金');
            // print_r($datalist);die;
            $i = 3;
            $j = 0;
            foreach ($datalist['list'] as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue('DO' . $i, $v['cash']);
                $objPHPExcel->getActiveSheet()->setCellValue('DP' . $i, $v['weixin']);
                $objPHPExcel->getActiveSheet()->setCellValue('DQ' . $i, $v['card']);
                $objPHPExcel->getActiveSheet()->setCellValue('DR' . $i, $v['medicine']);
                $objPHPExcel->getActiveSheet()->setCellValue('DS' . $i, $v['forsuzhou']);
                $objPHPExcel->getActiveSheet()->setCellValue('DT' . $i, $v['suzhoubank']);
                $objPHPExcel->getActiveSheet()->setCellValue('DU' . $i, $v['bohaibank']);
				                $objPHPExcel->getActiveSheet()->setCellValue('DV' . $i, $v['wxsaoma']);

                $objPHPExcel->getActiveSheet()->setCellValue('DW' . $i, $v['sum']);
                $i++;
                $j++;
            }
            $sum = $datalist['sum'];
            $objPHPExcel->getActiveSheet()->setCellValue('DO' . $i, $sum['cash']);
            $objPHPExcel->getActiveSheet()->setCellValue('DP' . $i, $sum['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('DQ' . $i, $sum['card']);
            $objPHPExcel->getActiveSheet()->setCellValue('DR' . $i, $sum['medicine']);
            $objPHPExcel->getActiveSheet()->setCellValue('DS' . $i, $sum['forsuzhou']);
            $objPHPExcel->getActiveSheet()->setCellValue('DT' . $i, $sum['suzhoubank']);
            $objPHPExcel->getActiveSheet()->setCellValue('DU' . $i, $sum['bohaibank']);
			            $objPHPExcel->getActiveSheet()->setCellValue('DV' . $i, $sum['wxsaoma']);

            $objPHPExcel->getActiveSheet()->setCellValue('DW' . $i, $sum['sum']);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('DX1', '汇总');
        $datalist = $Report->getMoneyReport($start, $end);
        $i = 3;
        $j = 0;
        foreach ($datalist['list'] as $v) {
            $objPHPExcel->getActiveSheet()->setCellValue('DX' . $i, $v['sum']);
            $i++;
            $j++;
        }
        $sum = $datalist['sum'];
        $objPHPExcel->getActiveSheet()->setCellValue('DX' . $i, $sum['sum']);


        $objPHPExcel->getActiveSheet()->setCellValue('A1', '项目');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', '日期');
       // $objPHPExcel->getActiveSheet()->mergeCells('DJ1:DJ2');
//        $objPHPExcel->getActiveSheet()->mergeCells('AK1:AK2');
//        $objPHPExcel->getActiveSheet()->mergeCells('AL1:AL2');
//        $objPHPExcel->getActiveSheet()->mergeCells('AM1:AM2');
//        $objPHPExcel->getActiveSheet()->mergeCells('AN1:AN2');
//        $objPHPExcel->getActiveSheet()->mergeCells('AO1:AO2');
//        $objPHPExcel->getActiveSheet()->mergeCells('AP1:AP2');
//        $objPHPExcel->getActiveSheet()->mergeCells('AQ1:AQ2');
//        $objPHPExcel->getActiveSheet()->mergeCells('AR1:AR2');
//        $objPHPExcel->getActiveSheet()->mergeCells('AS1:AS2');
       // $objPHPExcel->getActiveSheet()->getStyle('DJ1:DJ2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('B1:J1');
        $objPHPExcel->getActiveSheet()->mergeCells('K1:S1');
        $objPHPExcel->getActiveSheet()->mergeCells('T1:AB1');
        $objPHPExcel->getActiveSheet()->mergeCells('AC1:AK1');
        $objPHPExcel->getActiveSheet()->mergeCells('AL1:AT1');
        $objPHPExcel->getActiveSheet()->mergeCells('AU1:BC1');

        $objPHPExcel->getActiveSheet()->mergeCells('BD1:BL1');
        $objPHPExcel->getActiveSheet()->mergeCells('BM1:BU1');
        $objPHPExcel->getActiveSheet()->mergeCells('BV1:CD1');
        $objPHPExcel->getActiveSheet()->mergeCells('CE1:CM1');
        $objPHPExcel->getActiveSheet()->mergeCells('CN1:CV1');
        $objPHPExcel->getActiveSheet()->mergeCells('CW1:DE1');
        $objPHPExcel->getActiveSheet()->mergeCells('DF1:DN1');
        $objPHPExcel->getActiveSheet()->mergeCells('DO1:DW1');

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN, //细边框
                ),
            ),
        );
        if ($shid == 0) {
            $objPHPExcel->getActiveSheet()->getStyle('A1:DX' . $i)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A1:DX' . $i)->getFont()->setName('宋体');
        } else {
            $objPHPExcel->getActiveSheet()->getStyle('A1:WI' . $i)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A1:WI' . $i)->getFont()->setName('宋体');
        }



        ob_end_clean(); //清除缓冲区,避免乱码
        header('pragma:public');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="缴费统计表(' . date('m月d日', strtotime($start)) . '-' . date('m月d日', strtotime($end)) . ').xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
//catherine导出统计报表
    function everyMoney() {
        $start = I('start');
        $end = I('end');
        $array = explode('-', $start);
        $year = date('Y年', strtotime($start));
        $Report = A("Report");
        $newDate = date('Y年m月d日', strtotime($start));
        $endDate = date('Y年m月d日', strtotime($end));
        $res = $Report->cwReport($start,$end);
       // $yuan = $this->NumToCNMoney($res['allsum']['sum'],true,false);
       //print_r($res['list']);die;
        vendor('PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("ctos")
                ->setLastModifiedBy("ctos")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
        //填入主标题
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $year . '培训统计报表');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', '日期:' . $newDate.'-'.$endDate);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->setCellValue('A3', '地 点');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', '类 别');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', '单  价');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', '人  数');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', '应  收');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', '优  惠');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', '实  收');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', '现  金');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', '微  信');
        $objPHPExcel->getActiveSheet()->setCellValue('J3', '微信退款');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', '阳光卡');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', '工商银行');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', '退款');
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension(M)->setWidth(14);//设置列宽
        foreach ($res['list2'] as $k => $v) {
            $h = $k + 4;
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $h, '室  内');
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $h, $v['title']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $h, $v['amount']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $h, $v['count']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $h, $v['ysamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $h, $v['reduceamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $h, $v['realamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $h, $v['xianjin']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $h, $v['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $h, $v['refundmoney']);
			$objPHPExcel->getActiveSheet()->setCellValue('K' . $h, $v['yangguang']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $h, $v['gongshang']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $h, $v['refundmoney']);
        }
        foreach ($res['list'] as $m => $vv) {
            if(count($res['list2'])>0){
                $count =count($res['list2']);
                $n = $m + $count+4;
            }else{
                $n = $m + 4;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $n, '室  外');
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $n, $vv['title']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $n, $vv['amount']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $n, $vv['count']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $n, $vv['ysamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $n, $vv['reduceamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $n, $vv['realamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $n, $vv['xianjin']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $n, $vv['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $n, $vv['refundmoney']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $n, $vv['yangguang']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $n, $vv['gongshang']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $n, $vv['refundmoney']);
        }
        if(count($res['list'])>0){
            $f= $n+1;
        }elseif(count($res['list'])==0 && count($res['list2'])>0){
            $f= $h+1;
        }elseif(count($res['list'])==0 && count($res['list2'])==0){
            $f= 4;
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $f, '总计');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $f, $res['allsum']['count']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $f, $res['allsum']['ysamount']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $f, $res['allsum']['reduceamount']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $f, $res['allsum']['realamount']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $f, $res['allsum']['xianjin']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $f, $res['allsum']['weixin']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $f, $res['allsum']['refundmoney']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $f, $res['allsum']['yangguang']);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $f, $res['allsum']['gongshang']);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $f, $res['allsum']['refundmoney']);
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN, //细边框
                ),
            ),
        );
        if(count($res['list2'])!=0) {
            $objPHPExcel->getActiveSheet()->mergeCells('A4:A' . $h);
            $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }else if(count($res['list2'])==0 && count($res['list']) !=0 ) {
            $h = 3;
        }
        if(count($res['list']) !=0 && count($res['list2']) !=0 ){
            $w=$h+1;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$w.':A'.$n);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$w)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }else if(count($res['list'])!=0 && count($res['list2']) ==0){
            $objPHPExcel->getActiveSheet()->mergeCells('A4:A' . $n);
            $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }

        $bian=$f+1;
        $objPHPExcel->getActiveSheet()->getStyle('A1:M' . $bian)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A1:M' . $bian)->getFont()->setName('宋体');
        ob_end_clean(); //清除缓冲区,避免乱码
        header('pragma:public');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="培训订单流水(' . $newDate .'-'.$endDate. ').xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
//报名课程统计表
    function everySales() {
		$start = I('start');
        $end = I('end');
        $array = explode('-', $start);
        $year = date('Y年', strtotime($start));
        $Report = A("Report");
        $newDate = date('Y年m月d日', strtotime($start));
        $endDate = date('Y年m月d日', strtotime($end));
        $res = $Report->cwReport($start,$end);
       // $yuan = $this->NumToCNMoney($res['allsum']['sum'],true,false);
       //print_r($res['list']);die;
        vendor('PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("ctos")
                ->setLastModifiedBy("ctos")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
        //填入主标题
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $year . '培训统计报表');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', '日期:' . $newDate.'-'.$endDate);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:M1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->setCellValue('A3', '地 点');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', '类 别');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', '单  价');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', '人  数');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', '应  收');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', '优  惠');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', '实  收');
        $objPHPExcel->getActiveSheet()->setCellValue('H3', '现  金');
        $objPHPExcel->getActiveSheet()->setCellValue('I3', '微  信');
        $objPHPExcel->getActiveSheet()->setCellValue('J3', '微信退款');
        $objPHPExcel->getActiveSheet()->setCellValue('K3', '阳光卡');
        $objPHPExcel->getActiveSheet()->setCellValue('L3', '工商银行');
        $objPHPExcel->getActiveSheet()->setCellValue('M3', '退款');
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension(M)->setWidth(14);//设置列宽
        foreach ($res['list2'] as $k => $v) {
            $h = $k + 4;
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $h, '室  内');
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $h, $v['title']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $h, $v['amount']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $h, $v['count']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $h, $v['ysamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $h, $v['reduceamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $h, $v['realamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $h, $v['xianjin']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $h, $v['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $h, $v['refundmoney']);
			$objPHPExcel->getActiveSheet()->setCellValue('K' . $h, $v['yangguang']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $h, $v['gongshang']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $h, $v['refundmoney']);
        }
        foreach ($res['list'] as $m => $vv) {
            if(count($res['list2'])>0){
                $count =count($res['list2']);
                $n = $m + $count+4;
            }else{
                $n = $m + 4;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $n, '室  外');
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $n, $vv['title']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $n, $vv['amount']);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $n, $vv['count']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $n, $vv['ysamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $n, $vv['reduceamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $n, $vv['realamount']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $n, $vv['xianjin']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $n, $vv['weixin']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $n, $vv['refundmoney']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $n, $vv['yangguang']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $n, $vv['gongshang']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $n, $vv['refundmoney']);
        }
        if(count($res['list'])>0){
            $f= $n+1;
        }elseif(count($res['list'])==0 && count($res['list2'])>0){
            $f= $h+1;
        }elseif(count($res['list'])==0 && count($res['list2'])==0){
            $f= 4;
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $f, '总计');
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $f, $res['allsum']['count']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $f, $res['allsum']['ysamount']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $f, $res['allsum']['reduceamount']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $f, $res['allsum']['realamount']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $f, $res['allsum']['xianjin']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $f, $res['allsum']['weixin']);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $f, $res['allsum']['refundmoney']);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $f, $res['allsum']['yangguang']);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $f, $res['allsum']['gongshang']);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $f, $res['allsum']['refundmoney']);
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN, //细边框
                ),
            ),
        );
        if(count($res['list2'])!=0) {
            $objPHPExcel->getActiveSheet()->mergeCells('A4:A' . $h);
            $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }else if(count($res['list2'])==0 && count($res['list']) !=0 ) {
            $h = 3;
        }
        if(count($res['list']) !=0 && count($res['list2']) !=0 ){
            $w=$h+1;
            $objPHPExcel->getActiveSheet()->mergeCells('A'.$w.':A'.$n);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$w)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }else if(count($res['list'])!=0 && count($res['list2']) ==0){
            $objPHPExcel->getActiveSheet()->mergeCells('A4:A' . $n);
            $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }

        $bian=$f+1;
        $objPHPExcel->getActiveSheet()->getStyle('A1:M' . $bian)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A1:M' . $bian)->getFont()->setName('宋体');
        ob_end_clean(); //清除缓冲区,避免乱码
        header('pragma:public');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="培训订单流水(' . $newDate .'-'.$endDate. ').xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    function studentReport() {
        $start = I('start');
        $end = I('end');
        $array = explode('-', $start);
        $year = date('Y年', strtotime($start));
        $Report = A("Report");
        $newDate = date('Y年m月d日', strtotime($start));
        $endDate = date('Y年m月d日', strtotime($end));
        $schReport = $Report->schReport($start,$end);
        $count = $Report->countReport($start,$end);
        // $yuan = $this->NumToCNMoney($res['allsum']['sum'],true,false);
        //print_r($res['list']);die;
        vendor('PHPExcel');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("ctos")
            ->setLastModifiedBy("ctos")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        //填入主标题
        $objPHPExcel->getActiveSheet()->setCellValue('A1', $year . '学生报名课程统计报表,共计'.$count."个报名订单");
        $objPHPExcel->getActiveSheet()->setCellValue('A2', '日期:' . $newDate.'-'.$endDate);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->setCellValue('A3', '编号');
        $objPHPExcel->getActiveSheet()->setCellValue('B3', '姓名');
        $objPHPExcel->getActiveSheet()->setCellValue('C3', '性别');
        $objPHPExcel->getActiveSheet()->setCellValue('D3', '出生年月');
        $objPHPExcel->getActiveSheet()->setCellValue('E3', '联系电话');
        $objPHPExcel->getActiveSheet()->setCellValue('F3', '身份证号');
        $objPHPExcel->getActiveSheet()->setCellValue('G3', '班别');
        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension(M)->setWidth(14);//设置列宽
        for ($i=0;$i<=count($schReport);$i++) {
            $res = $Report->studentReport($schReport[$i],$start,$end);
                foreach ($res as $k => $v) {
                    if($i ==0){
                        $h = $k + 5;
                        $m = $h-1;
                        $n = $m-1;
                    }elseif($k == 0){
                        $h = $h + 5;
                        $m = $h-1;
                        $n = $m-1;
                    }else{
                        $h = $h + 1;
                    }
                    if($k == 0){
                        $r = 'A'.$n.':G'.$n;
                        $msg = $v['hour_s'].'-'.$v['hour_e'].$v['title'].'（'.$v['weekinfo'].')';
                        $objPHPExcel->getActiveSheet()->mergeCells($r);
                        $objPHPExcel->getActiveSheet()->setCellValue('A' .$n,$msg);
                        $a = 'A'.$n;
                        $objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $m, '编号');
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $m, '姓名');
                        $objPHPExcel->getActiveSheet()->setCellValue('C' . $m,  '性别');
                        $objPHPExcel->getActiveSheet()->setCellValue('D' .$m,  '出生年月');
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $m,  '联系电话');
                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $m,  '身份证号');
                        $objPHPExcel->getActiveSheet()->setCellValue('G' . $m,'班别');

                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $h, $k+1);
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $h, $v['name']);
                        $objPHPExcel->getActiveSheet()->setCellValue('C' . $h, $v['sex']);
                        $objPHPExcel->getActiveSheet()->setCellValue('D' . $h, $v['birthinfo']);
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $h, $v['phone']);
                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $h, $v['idcard']);
                        $objPHPExcel->getActiveSheet()->setCellValue('G' . $h, $v['classtype']);
                    }else{
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $h, $k+1);
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $h, $v['name']);
                        $objPHPExcel->getActiveSheet()->setCellValue('C' . $h, $v['sex']);
                        $objPHPExcel->getActiveSheet()->setCellValue('D' . $h, $v['birthinfo']);
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $h, $v['phone']);
                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $h, $v['idcard']);
                        $objPHPExcel->getActiveSheet()->setCellValue('G' . $h, $v['classtype']);
                    }
                }
        }
        ob_end_clean(); //清除缓冲区,避免乱码
        header('pragma:public');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="学生报名课程统计报表(' . $newDate .'-'.$endDate. ').xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    // 阿拉伯数字转中文大写金额
    function NumToCNMoney($num, $mode = true, $sim = true) {
        if (!is_numeric($num))
            return '含有非数字非小数点字符！';
        $char = $sim ? array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九') : array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
        $unit = $sim ? array('', '十', '百', '千', '', '万', '亿', '兆') : array('', '拾', '佰', '仟', '', '萬', '億', '兆');
        $retval = $mode ? '元' : '点';
        //小数部分
        if (strpos($num, '.')) {
            list($num, $dec) = explode('.', $num);
            $dec = strval(round($dec, 2));
            if ($mode) {
                $retval .= "{$char[$dec['0']]}角{$char[$dec['1']]}分";
            } else {
                for ($i = 0, $c = strlen($dec); $i < $c; $i++) {
                    $retval .= $char[$dec[$i]];
                }
            }
        }
        //整数部分
        $str = $mode ? strrev(intval($num)) : strrev($num);
        for ($i = 0, $c = strlen($str); $i < $c; $i++) {
            $out[$i] = $char[$str[$i]];
            if ($mode) {
                $out[$i] .= $str[$i] != '0' ? $unit[$i % 4] : '';
                if ($i > 1 and $str[$i] + $str[$i - 1] == 0) {
                    $out[$i] = '';
                }
                if ($i % 4 == 0) {
                    $out[$i] .= $unit[4 + floor($i / 4)];
                }
            }
        }
        $retval = join('', array_reverse($out)) . $retval;
        return $retval;
    }

}
