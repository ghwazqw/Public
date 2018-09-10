<?php
namespace Home\API;

class ExpInfoAPI
{
    //导出Excelw
    function expExcel($where){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["ht_lx"]  = array('like',"%$this->_keyword%");
            $where["ht_mc"]  = array('like',"%$this->_keyword%");
            $where["ht_qsf"]  = array('like',"%$this->_keyword%");
            //$where["ht_je"]  = array('like',"%$this->_keyword%");
            $where["ht_fkfs"]  = array('like',"%$this->_keyword%");
            //$where["ht_kssj"]  = array('like',"%$this->_keyword%");
            //$where["ht_jssj"]  = array('like',"%$this->_keyword%");
            $where["ht_bz"]  = array('like',"%$this->_keyword%");
            $where['_logic']='OR';
        }

        $m = M ('ht_tb');  //
        // $datas['order_p_name'] = $p_name;
        $data = $m->where($where)->order("id DESC")->select();
        foreach ($data as $k => $v)
        {
            $data[$k]['id']=$v['id'];
        }
        //var_export($data);
        //exit;
        //用vendor导入PHPExcel类库
        vendor("PHPExcel.PHPExcel");
        $filename="ht_tb信息表";
        $headArr=array("ID","合同类型","合同名称","签署方","合同金额","付款方式","开始日期","结束日期","是否付款完成","备注");
        $getExcel=new ExcelAPI();
        $getExcel->getExcel($filename,$headArr,$data);
    }
    /*电子设备导出Excel信息*/
    function expDzsbExcel($where){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["zc_pp"]  = array('like',"%$this->_keyword%");  //品牌
            $where["zc_xh"]  = array('like',"%$this->_keyword%");  //型号
            $where["zc_scrq"]  = array('like',"%$this->_keyword%");  //生产日期
            $where["zc_sccj"]  = array('like',"%$this->_keyword%");  //生产厂家
            $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");  //出厂产品编号
            $where["zc_yt"]  = array('like',"%$this->_keyword%");  //用途
            $where["zc_jgdm"]  = array('like',"%$this->_keyword%");  //机构代码
            $where["zc_jgmc"]  = array('like',"%$this->_keyword%");  //机构名称
            $where["zc_jgxzjb"]  = array('like',"%$this->_keyword%");  //机构行政级别
            $where["zc_jgxzjbxx"]  = array('like',"%$this->_keyword%");  //机构行政级别细项
            $where["zc_bh"]  = array('like',"%$this->_keyword%");  //资产编号|int
            $where["zc_lx"]  = array('like',"%$this->_keyword%");  //资产类型|LxSelect|zclx_tb|id|cglx_mc
            $where["zc_lxid"]  = array('like',"%$this->_keyword%");  //类型ID
            $where["zc_rjlx"]  = array('like',"%$this->_keyword%");  //资产二级分类
            $where["zc_rjlxid"]  = array('like',"%$this->_keyword%");  //二级类型ID
            $where["zc_mc"]  = array('like',"%$this->_keyword%");  //资产名称
            $where["zc_jldw"]  = array('like',"%$this->_keyword%");  //计量单位
            $where["zc_yz"]  = array('like',"%$this->_keyword%");  //原值
            $where["zc_dj"]  = array('like',"%$this->_keyword%");  //单价
            $where["zc_azcb"]  = array('like',"%$this->_keyword%");  //其中:安装成本
            $where["zc_jz"]  = array('like',"%$this->_keyword%");  //净值
            $where["zc_sfzjbz"]  = array('like',"%$this->_keyword%");  //是否折旧标志|RadioSelect
            $where["zc_zjnxlx"]  = array('like',"%$this->_keyword%");  //折旧年限类型
            $where["zc_ljzj"]  = array('like',"%$this->_keyword%");  //累计折旧
            $where["zc_bqzj"]  = array('like',"%$this->_keyword%");  //本期折旧
            $where["zc_gjrq"]  = array('like',"%$this->_keyword%");  //购建日期
            $where["zc_rzrq"]  = array('like',"%$this->_keyword%");  //入帐日期
            $where["zc_qyrq"]  = array('like',"%$this->_keyword%");  //启用日期
            $where["zc_qdfs"]  = array('like',"%$this->_keyword%");  //取得方式
            $where["zc_ccsybm"]  = array('like',"%$this->_keyword%");  //财产使用部门
            $where["zc_sfxz"]  = array('like',"%$this->_keyword%");  //是否闲置
            $where["zc_ccglbm"]  = array('like',"%$this->_keyword%");  //财产管理部门
            $where["zc_txm"]  = array('like',"%$this->_keyword%");  //条形码|Rcode
            $where["zc_zrr"]  = array('like',"%$this->_keyword%");  //责任人
            $where["zc_pfdh"]  = array('like',"%$this->_keyword%");  //批复单号
            $where["zc_kpsm"]  = array('like',"%$this->_keyword%");  //卡片说明
            $where["zc_czrq"]  = array('like',"%$this->_keyword%");  //出帐日期
            $where["zc_czlx"]  = array('like',"%$this->_keyword%");  //出帐类型
            $where["zc_czyy"]  = array('like',"%$this->_keyword%");  //出帐原因
            $where["zc_zcdjr"]  = array('like',"%$this->_keyword%");  //资产登记人
            $where["zc_bz"]  = array('like',"%$this->_keyword%");  //备注
            $where["zc_zt"]  = array('like',"%$this->_keyword%");  //设备状态(0待分配,1在用,2维修,3保养,4,停用,10报废)
            $where['_logic']='OR';
        }

        $m = M ('dzsb_tb');  //
        // $datas['order_p_name'] = $p_name;
        $data = $m->where($where)->order("id DESC")->select();
        foreach ($data as $k => $v)
        {
            $data[$k]['id']=$v['id'];
        }
        //var_export($data);
        //exit;
        //用vendor导入PHPExcel类库
        vendor("PHPExcel.PHPExcel");
        $filename="zc_cq_dzsb_tb信息表";
        $headArr=array("ID","品牌","型号","生产日期","生产厂家","出厂产品编号","用途","机构代码","机构名称","机构行政级别","机构行政级别细项","资产编号","资产类型","类型ID","资产二级分类","二级类型ID","资产名称","计量单位","原值","单价","其中:安装成本","净值","是否折旧标志","折旧年限类型","累计折旧","本期折旧","购建日期","入帐日期","启用日期","取得方式","财产使用部门","是否闲置","财产管理部门","条形码","责任人","批复单号","卡片说明","出帐日期","出帐类型","出帐原因","资产登记人","备注","设备状态(0待分配,1在用,2维修,3保养,4,停用,10报废)");
        $getExcel=new ExcelAPI();
        $getExcel->getExcel($filename,$headArr,$data);
    }
    /*机械设备导出Excel信息*/
    function expDqsbExcel($where){
        $this->_keyword=I("keyword");
        if ($this->_keyword!=""){
            $where["zc_pp"]  = array('like',"%$this->_keyword%");  //品牌
            $where["zc_xh"]  = array('like',"%$this->_keyword%");  //型号
            $where["zc_scrq"]  = array('like',"%$this->_keyword%");  //生产日期
            $where["zc_cccpbh"]  = array('like',"%$this->_keyword%");  //出厂产品编号
            $where["zc_sccj"]  = array('like',"%$this->_keyword%");  //生产厂家
            $where["zc_jgdm"]  = array('like',"%$this->_keyword%");  //机构代码
            $where["zc_jgmc"]  = array('like',"%$this->_keyword%");  //机构名称
            $where["zc_jgxzjb"]  = array('like',"%$this->_keyword%");  //机构行政级别
            $where["zc_jgxzjbxx"]  = array('like',"%$this->_keyword%");  //机构行政级别细项
            $where["zc_bh"]  = array('like',"%$this->_keyword%");  //资产编号|int
            $where["zc_lx"]  = array('like',"%$this->_keyword%");  //资产类型|LxSelect|zclx_tb|id|cglx_mc
            $where["zc_lxid"]  = array('like',"%$this->_keyword%");  //类型ID
            $where["zc_rjlx"]  = array('like',"%$this->_keyword%");  //资产二级分类
            $where["zc_rjlxid"]  = array('like',"%$this->_keyword%");  //二级类型ID
            $where["zc_mc"]  = array('like',"%$this->_keyword%");  //资产名称
            $where["zc_jldw"]  = array('like',"%$this->_keyword%");  //计量单位
            $where["zc_yz"]  = array('like',"%$this->_keyword%");  //原值
            $where["zc_dj"]  = array('like',"%$this->_keyword%");  //单价
            $where["zc_azcb"]  = array('like',"%$this->_keyword%");  //其中:安装成本
            $where["zc_jz"]  = array('like',"%$this->_keyword%");  //净值
            $where["zc_sfzjbz"]  = array('like',"%$this->_keyword%");  //是否折旧标志|RadioSelect
            $where["zc_zjnxlx"]  = array('like',"%$this->_keyword%");  //折旧年限类型
            $where["zc_ljzj"]  = array('like',"%$this->_keyword%");  //累计折旧
            $where["zc_bqzj"]  = array('like',"%$this->_keyword%");  //本期折旧
            $where["zc_gjrq"]  = array('like',"%$this->_keyword%");  //购建日期
            $where["zc_rzrq"]  = array('like',"%$this->_keyword%");  //入帐日期
            $where["zc_qyrq"]  = array('like',"%$this->_keyword%");  //启用日期
            $where["zc_qdfs"]  = array('like',"%$this->_keyword%");  //取得方式
            $where["zc_ccsybm"]  = array('like',"%$this->_keyword%");  //财产使用部门
            $where["zc_sfxz"]  = array('like',"%$this->_keyword%");  //是否闲置
            $where["zc_ccglbm"]  = array('like',"%$this->_keyword%");  //财产管理部门
            $where["zc_txm"]  = array('like',"%$this->_keyword%");  //条形码|Rcode
            $where["zc_zrr"]  = array('like',"%$this->_keyword%");  //责任人
            $where["zc_pfdh"]  = array('like',"%$this->_keyword%");  //批复单号
            $where["zc_kpsm"]  = array('like',"%$this->_keyword%");  //卡片说明
            $where["zc_czrq"]  = array('like',"%$this->_keyword%");  //出帐日期
            $where["zc_czlx"]  = array('like',"%$this->_keyword%");  //出帐类型
            $where["zc_czyy"]  = array('like',"%$this->_keyword%");  //出帐原因
            $where["zc_zcdjr"]  = array('like',"%$this->_keyword%");  //资产登记人
            $where["zc_bz"]  = array('like',"%$this->_keyword%");  //备注
            $where["zc_zt"]  = array('like',"%$this->_keyword%");  //设备状态(0待分配,1在用,2维修,3保养,4,停用,10报废)
            $where["zc_yt"]  = array('like',"%$this->_keyword%");  //用途
            $where['_logic']='OR';
        }
        $m = M ('dqsb_tb');  //
        // $datas['order_p_name'] = $p_name;
        $data = $m->where($where)->order("id DESC")->select();
        foreach ($data as $k => $v)
        {
            $data[$k]['id']=$v['id'];
        }
        //var_export($data);
        //exit;
        //用vendor导入PHPExcel类库
        vendor("PHPExcel.PHPExcel");
        $filename="zc_cq_dqsb_tb信息表";
        $headArr=array("ID","品牌","型号","生产日期","出厂产品编号","生产厂家","机构代码","机构名称","机构行政级别","机构行政级别细项","资产编号","资产类型","类型ID","资产二级分类","二级类型ID","资产名称","计量单位","原值","单价","其中:安装成本","净值","是否折旧标志","折旧年限类型","累计折旧","本期折旧","购建日期","入帐日期","启用日期","取得方式","财产使用部门","是否闲置","财产管理部门","条形码","责任人","批复单号","卡片说明","出帐日期","出帐类型","出帐原因","资产登记人","备注","设备状态(0待分配,1在用,2维修,3保养,4,停用,10报废)","用途");
        $getExcel=new ExcelAPI();
        $getExcel->getExcel($filename,$headArr,$data);
    }
}

