<?php

namespace Home\API;

class ProductAPI
{
    public $_main_data = array(); //主数据数组
    public $_dal_data = array(); //子数据数组
    public $_page_size = "50"; //每页显示条数
    public $_page_bar = ""; //分布组件需要展示的内容
    public $_page_count = ""; //统计数量
    //public $_main_data=array(); //主表数据
    public $_dateil_data = array();  //子表数据
    public $_keyword = ""; //关键字数据
    public $_Msg = ""; //信息输出

    //加载菜单数据
    function LoadSortInfo($lx)
    {
        $SortTable = M("productcategory_tb");
        if ($lx != 0) {
            $where["sort_jb"] = array("eq", $lx);
        }
        $this->_main_data = $SortTable->where($where)->order("id")->select();
    }

    //加载子分类信息
    function LoadSsoftInfo($sjid)
    {
        $SortTable = M("productcategory_tb");
        $where["sort_sjid"] = array("eq", $sjid);
        $this->_main_data = $SortTable->where($where)->order("id")->select();
    }


    //加载产品分类树
    function LoadSortTree()
    {
        $Table = M("productcategory_tb");
        $ret = $Table->order("id")->getField('id,sort_sjid,sort_mc as text');
        //echo $Table->_sql();
        //var_export($ret);
        $this->_main_data = $ret;
        //echo json_encode($ret);
    }


    //加载分类详细信息
    function LoadSortDal($id)
    {
        $Table = M("productcategory_tb");
        $where["id"] = array("eq", $id);
        $this->_dal_data = $Table->where($where)->select();
    }

    //编辑分类信息
    function SortEdit($id)
    {
        $Table = M("productcategory_tb");
        $Table->sort_mc = I("sort_mc");
        $Table->sort_sfyx = I("sort_sfyx");
        if (!$id) {
            if (!I("sort_sjid")) {
                $sjid = 0;
                $js = 1;

            } else {
                $sjid = I("sort_sjid");
                $js = 2;
            }
            $Table->sort_jb = $js;
            $Table->sort_sjid = $sjid;
            $ret = $Table->add();
        } else {
            $where["id"] = array("eq", $id);
            $count = $Table->where($where)->count();
            if (!$count || $count == 0) {
                $ret = 0;
            } else {
                $ret = $Table->where($where)->save();
            }
        }
        if ($ret) {
            return true;
        } else {
            return false;
        }
    }

    //规格型号信息读取
    function pt_producttpl_tbmatedata($id)
    {

        $limit = I("limit"); //从前端获取每页显示的数量
        $order = I("order"); //排序方式获取
        $sort = I("sort"); //排序字段获取
        $offset = I("offset"); //排序位置获取
        $search = I("search"); //获取搜索关键字

        if (!$sort) {
            $sort = "id"; //默认排序字段
        }
        if (!$order) {
            $order = "desc"; //默认排序方式
        }
        if (!$offset) {
            $offset = 0; //默认数据读取
        }
        if (!$limit) {
            $limit = $this->_page_size; //前台未传参时，默认每页显示为50条数据
        }

        $TableName = M("ptpl_vm"); //注意去除表头
        $this->_keyword = $search;
        if ($this->_keyword != "") {
            $where["sort_id"] = array('like', "%$this->_keyword%");
            $where["tpl_name"] = array('like', "%$this->_keyword%");
            $where["tpl_sort"] = array('like', "%$this->_keyword%");
            $where['_logic'] = 'OR';
        }
        //加载主表数据
        if (!$id) {
            $this->_page_count = $count = $TableName->where($where)->count(); //加载获取到的数据量
        }else{
            $this->_page_count = $TableName->where("sort_id=$id")->count();
        }
        $Page = new \Think\Page($count, $limit);
        //$Page->parameter=$this->_keyword;


        $this->_page_bar = $Page->show(); //把分布内容赋值给变量
        $this->_page_ys = $Page->totalPages;
        if (!$id) {
            $this->_main_data = $TableName->where($where)->order($sort . " " . $order)->LIMIT($offset . ',' . $limit)->select(); //据取值完成
        } else { //ID不为空时读取详细信息
            $this->_main_data = $TableName->where("sort_id=$id")->order($sort . " " . $order)->LIMIT($offset . ',' . $limit)->select(); //据取值完成
        }
        //echo $TableName->getLastSql();
        if ($count == 0) {
            $this->_Msg = '数据结果为0';
        } else {
            $this->_Msg = '获取成功';
        }
    }

    //编辑规格模板信息
    function EditTpl($id)
    {
        $AddData = D("producttpl_tb");  //注意去除前缀
        $AddData->sort_id = I("sort_id"); //类型ID
        $AddData->tpl_name = I("tpl_name"); //模板名称
        $AddData->tpl_sort = I("tpl_sort"); //模板要求类型
        $AddData->tpl_code=I("tpl_code"); //模板code
        if (!$id) {
            $ret = $AddData->add();
        } else {
            $where["id"] = array("eq", $id);
            $ret = $AddData->where($where)->save();
        }
        if ($ret) {
            return true;
        } else {
            return false;
        }
    }

    //删除规格类型信息
    public function TplDel($id)
    {
        $io = new DelDataAPI();
        $table = "producttpl_tb";
        if ($io->DelInfo($table, $id)) {
            $this->_Msg = '删除成功';
            return true;
        } else {
            $this->_Msg = '删除失败';
            return false;
        }
    }
    //加载商品信息表
    function pt_product_tbmatedata($id)
    {
        //echo $id;

        $limit = I("limit"); //从前端获取每页显示的数量
        $order = I("order"); //排序方式获取
        $sort = I("sort"); //排序字段获取
        $offset = I("offset"); //排序位置获取
        $search = I("search"); //获取搜索关键字

        if (!$sort) {
            $sort = "id"; //默认排序字段
        }
        if (!$order) {
            $order = "desc"; //默认排序方式
        }
        if (!$offset) {
            $offset = 0; //默认数据读取
        }
        if (!$limit) {
            $limit = $this->_page_size; //前台未传参时，默认每页显示为50条数据
        }

        $TableName = M("product_vm"); //注意去除表头
        $this->_keyword = $search;
        if ($this->_keyword != "") {
            $where["product_name"] = array('like', "%$this->_keyword%");
            $where["sort_id"] = array('like', "%$this->_keyword%");
            $where["product_price"] = array('like', "%$this->_keyword%");
            $where["product_costprice"] = array('like', "%$this->_keyword%");
            $where["product_taxrate"] = array('like', "%$this->_keyword%");
            $where["product_note"] = array('like', "%$this->_keyword%");
            $where["product_status"] = array('like', "%$this->_keyword%");
            $where["product_volumes"] = array('like', "%$this->_keyword%");
            $where['_logic'] = 'OR';
        }
        //加载主表数据
        if (!$id) {
            $this->_page_count = $count = $TableName->where($where)->count(); //加载获取到的数据量
        }else{
            $this->_page_count = $count = $TableName->where("id=$id")->count(); //加载获取到的数据量
        }
        $Page = new \Think\Page($count, $limit);
        //$Page->parameter=$this->_keyword;


        $this->_page_bar = $Page->show(); //把分布内容赋值给变量
        $this->_page_ys = $Page->totalPages;
        if (!$id) {
            $this->_main_data = $TableName->where($where)->order($sort . " " . $order)->LIMIT($offset . ',' . $limit)->select(); //据取值完成
        } else { //ID不为空时读取详细信息
            $this->_main_data = $TableName->where("id=$id")->order($sort . " " . $order)->LIMIT($offset . ',' . $limit)->select(); //据取值完成
        }
        //echo $TableName->getLastSql();
        if ($count == 0) {
            $this->_Msg = '数据结果为0';
        } else {
            $this->_Msg = '获取成功';
        }
    }

    //编辑商品信息
    function EditProduct($id)
    {
        if (!I("product_name")){
            $this->_Msg='信息不完整，非法操作';
            return false;
        }else{
            $AddData = M("product_tb");  //注意去除前缀
            $AddData->product_name = I("product_name"); //商品名称
            $AddData->sort_id = I("sort_id"); //商品分类ID
            $AddData->product_price = I("product_price"); //商品出售价格
            $AddData->product_costprice = I("product_costprice"); //商品成本价
            $AddData->product_taxrate = I("product_taxrate"); //折扣
            $AddData->product_note = $_POST["content"]; //商口详细说明
            $AddData->Product_pp= I("Product_pp"); //商品品牌
            if (I("product_volumes")==0){ //可销售数量为0时，商品不可上架
                $AddData->product_status = 0; //商品状态
            }else{
                $AddData->product_status = I("product_status"); //商品状态
            }
            $AddData->product_volumes = I("product_volumes"); //可销售数量
            if (!$id){
                $Edit=1;
                $ret=$AddData->add();
            }else{
                $Edit=0;
                $ret=$AddData->where("id=$id")->save();
            }
            if ($ret){
                $this->_Msg='编辑成功，';
                $sort_id=I("sort_id");
                //处理规格型号
                if ($this->ProductGgxh($sort_id,$ret,$Edit)==1){
                    $this->_Msg=$this->_Msg.'规格型号处理成功，';
                }else{
                    $this->_Msg=$this->_Msg.'规格型号处理失败，';
                    //return true;
                }
                //处理图片信息
                $pid=$ret;
                if ($this->EditPimgItem('admin',$pid,'商品图片')){
                    $this->_Msg=$this->_Msg.'商品图片处理成功。';
                }else{
                    $this->_Msg=$this->_Msg.'没有上传商品图片或保存失败。';
                    //return true;
                }
                //清除商品图片临时文件
                $this->ClearTmp('admin');
                return true;
            }else{
                $this->_Msg='编辑失败';
                return false;
            }
        }
    }
    //编辑商品的规格型号
    function ProductGgxh($sort_id,$id,$Edit){
        //exit($id);
        $TplTbale=M("producttpl_tb"); //规格模板
        $EditTable=M("product_meta_tb"); //商品扩展
        $where["sort_id"]=array("eq",$sort_id); //类型ID
        $RetInfo=$TplTbale->where($where)->select();
        //var_dump($RetInfo);
        foreach ($RetInfo as $info){
            $value=$info["tpl_code"];
            $EditTable->im_key=$info["tpl_code"]; //记录主code
            $EditTable->im_value=I("$value"); //记录具体值
            $EditTable->im_title=$info["tpl_name"]; //记录模板标题
            $EditTable->product_id=$id; //记录商品ID
            if ($Edit==1){
                $ret=$EditTable->add();
            }else{
                $EditWhere["im_key"]=array("eq",$value);
                $ret=$EditTable->where($EditWhere)->save();
            }
        }
        if ($ret){
            return 1;
        }else{
            return 0;
        }
    }
    //改变商品上下架状态
    function ProductSxj($id,$status,$vol){
        $EditData = M("product_tb");  //注意去除前缀
        $where["id"]=array("eq",$id);
        $count=$EditData->where($where)->count();
        if (!$count){
            $this->_Msg = '信息读取错误';
            return false;
        }else{
            if ($vol==0){
                $this->_Msg = '可销售数量不足,操作失败';
                return false;
            }else{
                $EditData->product_status=$status;
                $ret=$EditData->where($where)->save();
                if ($ret){
                    $this->_Msg='操作成功';
                    return true;
                }else{
                    $this->_Msg='操作失败';
                    return false;
                }
            }

        }
    }
    //删除商品信息
    public function ProductDel($id)
    {
        $io = new DelDataAPI();
        $table = "product_tb";
        if ($io->DelInfo($table, $id)) {
            $this->_Msg = '删除成功';
            return true;
        } else {
            $this->_Msg = '删除失败';
            return false;
        }
    }
    //编辑商品信息
    function EditPimgItem($UserName,$Pid,$keyword){
        $AdTable=M("productimg_tb");
        $TmpTable=M("imgtmp_tb");
        //读取临时表信息
        $TmpWhere["username"]=array("eq",$UserName);
        $TmpWhere["sort"]=array("eq","sp");
        $Tmp=$TmpTable->where($TmpWhere)->select();
        foreach ($Tmp as $item){
            $AdTable->imgurl=$item["imageurl"];
            $AdTable->keyword=$keyword;
            $AdTable->product_id=$Pid;
            $AdTable->updatetime=$item["updatetime"];
            $AdTable->add();
        }
        return true;
    }
    //清空临时表
    function ClearTmp($username){
        $ii=new DelDataAPI();
        $where["username"]=array("eq",$username);
        $where["sort"]=array("eq","sp");
        if ($ii->DelSortInfo('imgtmp_tb',$where)){
            return true;
        }else{
            return false;
        }
    }
    //商品图片信息
    function ImgInfo($id){
        $ViewTable=M("productimg_tb");
        $where["product_id"]=array("eq",$id);
        $ret=$ViewTable->where($where)->select();
        $this->_dateil_data=$ret;
        $this->_Msg="获取成功";
    }
}	
