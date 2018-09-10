<?php
namespace Home\Controller;
use Home\API\ExcelAPI;
use Think\Controller;

class InoutController extends Controller {
    /**
     *
     * 导出Excel
     */


    /**
     *
     * 显示导入页面 ...
     */

    /**实现导入excel
     **/
    function impUser(){
        if (!empty($_FILES)) {
            $upload = new \Think\Upload();// 实例化上传类
            $filepath='./Public/Uploads/';
            $upload->exts = array('xlsx','xls');// 设置附件上传类型
            $upload->rootPath  =  $filepath; // 设置附件上传根目录
            $upload->saveName  =     'time';
            $upload->autoSub   =     false;
            if (!$info=$upload->upload()) {
                $this->error($upload->getError());
            }
            foreach ($info as $key => $value) {
                unset($info);
                $info[0]=$value;
                $info[0]['savepath']=$filepath;
            }
            vendor("PHPExcel.PHPExcel");
            $file_name=$info[0]['savepath'].$info[0]['savename'];

            //$objReader = \PHPExcel_IOFactory::createReader('Excel5');
            $objReader=new \PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            //$highestRow =$highestRow-3;
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            //引入日期处理类
            $format_date=new \PHPExcel_Shared_Date();
            $j=0;
            for($i=3;$i<=$highestRow;$i++)
            {
                $data['dw_name']= $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue(); //单位名称
                $tname= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
                //$data['tid']=Gettid($tname);
                $data['dw_zrr']= $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue(); //自然人
                $data['dw_bh']= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue(); //编号
                $data['dw_spmc']= $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();  //商品名称
                $data['dw_gg']= $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue(); //规格
                $data['dw_bzdw']= $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue(); //包装单位
                $data['dw_sccj']= $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue(); //生产厂家
                //处理日期数据
                //指定H列为日期型数据
                $cell= $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
                $date_rq = gmdate("Y-m-d", $format_date::ExcelToPHP($cell));
                $data['dw_rq']=$date_rq; //日期
                $data['dw_ph']= $objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
                $data['dw_sl']= $objPHPExcel->getActiveSheet()->getCell("J".$i)->getValue();
                $data['dw_hsj']= $objPHPExcel->getActiveSheet()->getCell("K".$i)->getValue();
                $data['dw_hsje']= $objPHPExcel->getActiveSheet()->getCell("L".$i)->getValue();
                $dw_kprq= $objPHPExcel->getActiveSheet()->getCell("M".$i)->getValue();
                $date_kprq=gmdate("Y-m-d", $format_date::ExcelToPHP($dw_kprq));
                $data['dw_kprq']=$date_kprq;
                $data['dw_fphm']= $objPHPExcel->getActiveSheet()->getCell("N".$i)->getValue();
                $data['dw_kpsl']= $objPHPExcel->getActiveSheet()->getCell("O".$i)->getValue();
                $data['dw_jhsje']= $objPHPExcel->getActiveSheet()->getCell("P".$i)->getValue();
                // if(M('Contacts')->where("name='".$data['name']."' and phone=$data['phone']")->find()){
                /*if(M('Contacts')->where("phone='".$data['phone']."'")->find()){
                    //如果存在相同联系人。判断条件：电话 两项一致，上面注释的代码是用姓名/电话判断
                }else{
                    M('Contacts')->add($data);
                    $j++;
                }*/

                M('input_tb')->add($data);
                $j++;
            }
           echo '导入成功！本次导入数据：'.$j;
        }else
        {
            $this->error("请选择上传的文件");
        }
    }
}

?>