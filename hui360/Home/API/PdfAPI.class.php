<?php
/**
 * Created by PhpStorm.
 * User: ghw
 * Date: 2017/10/1
 * Time: 下午10:17
 */
namespace Home\API;
class PdfAPI{
    function expPDF($html='<h1 style="color:red">hello word</h1>'){
        vendor('Tcpdf.tcpdf');
        //实例化
        $pdf=new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        // 设置文档信息
        $pdf->SetCreator('Hello');
        $pdf->SetAuthor('Ghw');
        $pdf->SetTitle('中国公路科技成果转化平台');
        $pdf->SetSubject('公路科技');
        $pdf->SetKeywords('公路科技,公路');

        // 设置页眉和页脚信息
            $pdf->SetHeaderData('d_logo.png', 30, 'Highwaytech.cn', '中国公路科技成果转化平台',
            array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // 设置页眉和页脚字体
        $pdf->setHeaderFont(Array('stsongstdlight', '', '8'));
        $pdf->setFooterFont(Array('helvetica', '', '8'));

        // 设置默认等宽字体
        $pdf->SetDefaultMonospacedFont('courier');

        // 设置间距
        $pdf->SetMargins(15, 27, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        // 设置分页
        $pdf->SetAutoPageBreak(TRUE, 25);

        // set image scale factor
        $pdf->setImageScale(1.25);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        //设置字体
        $pdf->SetFont('stsongstdlight', '', 12);

        $pdf->AddPage();
        $html="";
        $html.= '<br /><br /><br /><br /><br />你好，PDFtest';


        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);;

        //输出PDF
        ob_end_clean();
        $pdf->Output('t.pdf', 'I');

    }

}