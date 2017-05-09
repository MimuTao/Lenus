<?php  
	/**
      *xx表示下标
      *data[xx0][name]:sSearch
      *data[xx0][value]:~~~  表示搜索的值
      *
      *data[xx1][name]:iDisplayLength
      *data[xx1][value]:bbb 表示每页显示的值
      *
      *data[xx2][name]:iDisplayStart
      *data[xx2][value]:aaa 表示每页的起始值 从0开始起计
      *
      *上下一起构成limit aaabbb,
      *
      *data[xx][name]:iSortCol_0 按哪行排序，第一行为0
      *data[xx][value]:0
      *
      *data[xx][name]:sSortDir_0 按升序还是按降-序
      *data[xx][value]:desc 
      *
      *data[xx][name]:iSortingCols 共有几行排序
      *data[xx][value]:1
      *
      *data[xx][name]:iColumns 共多少列
      *data[xx][value]:9 
      *
      *从5开始，每列占5个位
      *4+5*9+1=50
      *
      *下一位是搜索字段
      *位于 4+5*9+1=50
      *下一位 50+1 无用
      *下一位 51+1 排序列 第一个排序列
      *下一位 52+1 排序方式列 asc desc
      *但是要先取最后一位，有多少位进行了排序
      **/
	class SqlHelper{
		private $Data;
		private $ParseValue;
		public  $Result;
		public function __construct($string=''){
			$this->Data       = array();
			$this->ParseValue = array();
			$this->Result     = array();
		}
		public function set_Data($arr){
			$this->Data     = $arr;//原始data
		}
		public function set_ParseValue($arr){
			$this->ParseValue = $arr;//id,key
		}
		public function parse($condition = true){
			if($condition){
				$size = count($this->Data);
				$this->Result['iColumns']       = intval($this->Data[1]['value']);//列数
				$iColumns                       = intval($this->Data[1]['value']);
				$this->Result['iDisplayStart']  = intval($this->Data[3]['value']);//起始位
				$this->Result['iDisplayLength'] = intval($this->Data[4]['value']);//起始查询行数
				$this->Result['sSearch']        = $this->Data[4+5*$iColumns+1]['value'];//搜索字段
				$this->Result['iSortingCols']   = intval($this->Data[$size-1]['value']);//排序列数
				$iSortingCols                   = intval($this->Data[$size-1]['value']);
				$orderby = ' ';
				//在这之前，要把参数格式化下
				for ($i=0; $i < $iSortingCols-1; $i++) {
					# code...
					$orderby .= '`'.$this->ParseValue[$this->Data[4+5*$iColumns+3+$i*2]['value']].'` '.$this->Data[4+5*$iColumns+4+$i*2]['value'].',';
				}
				$orderby   .= '`'.$this->ParseValue[$this->Data[4+5*$iColumns+3+$i*2]['value']].'` '.$this->Data[4+5*$iColumns+4+$i*2]['value'];
				$this->Result['OrderyBy'] = $orderby;
				//var_dump($this->Result);
				return $this->Result;
			}
			else{
				$size = count($this->Data);
				$this->Result['iColumns']       = intval($this->Data[1]['value']);//列数
				$iColumns                       = intval($this->Data[1]['value']);
				$this->Result['iDisplayStart']  = intval($this->Data[3]['value']);//起始位
				$this->Result['iDisplayLength'] = intval($this->Data[4]['value']);//起始查询行数
				$this->Result['sSearch']        = $this->Data[4+5*$iColumns+1]['value'];//搜索字段
				$this->Result['iSortingCols']   = intval($this->Data[$size-1]['value']);//排序列数
				$iSortingCols                   = intval($this->Data[$size-1]['value']);
				$orderby = ' ';
				//在这之前，要把参数格式化下
				for ($i=0; $i < $iSortingCols-1; $i++) {
					# code...
					$orderby .= $this->ParseValue[$this->Data[4+5*$iColumns+3+$i*2]['value']].' '.$this->Data[4+5*$iColumns+4+$i*2]['value'].',';
				}
				$orderby   .= $this->ParseValue[$this->Data[4+5*$iColumns+3+$i*2]['value']].' '.$this->Data[4+5*$iColumns+4+$i*2]['value'];
				$this->Result['OrderyBy'] = $orderby;
				//var_dump($this->Result);
				return $this->Result;
			}

			/*array
				'iColumns' => int 9
				'iDisplayStart' => int 0
				'iDisplayLength' => int 10
				'sSearch' => string 'ww' (length=2)
				'iSortingCols' => int 4
				'OrderyBy' => string 'order by `id` asc,`tel` asc,`user_name` asc,`role_id` asc' (length=57)*/
		}

	}
?>