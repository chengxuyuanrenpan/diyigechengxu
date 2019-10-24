<?php
namespace User\Controller;
use Think\Controller;
class BuqianController extends CommonController {

	/*---------------------------补签--------------------------------------*/
	public function index($user='',$check=''){
		$check = $this->unlock_url($check);
		$kkb = $user.$user;
		if(!$user){
			$this->ajaxReturn(array('status'=>500,'info'=>'用户不存在'));
		}else{
			if($check!=$kkb){
				$this->ajaxReturn(array('status'=>301,'info'=>'非法请求'));
			}

			//获取本周周一到周日的日期
	        $week = date('w');
	        $aa = $week-3;
	        $bb = $week+3;
	       
	        for ($i=$aa; $i <=$bb ; $i++) {
	        	$kentas[$i] = date('Ymd', (time() + ($i - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600));
	        	$tyt = strtotime(date('Ymd', (time() + ($i - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600)));
	        	$xingqi[$i] = date('w', $tyt);
	        }
	       
	        foreach ($xingqi as $key => $value) {
	        	if($value ==1){$value = "一";}elseif($value ==2){$value = "二";}elseif($value ==3){
	        		$value = "三";
	        	}elseif($value ==4){$value = "四";}elseif($value ==5){$value = "五";}elseif($value ==6){$value = "六";}else{$value = "天";}
	        	$otm[$key] = $value;
	        }

	        //日期
	        foreach ($kentas as $key => $value) {
	        	$signs = M('sign')->where(array('user_id'=>$user,'date'=>$value))->order("create_time desc")->find();
	        	$tuyt[$key] 	= $value;
	        	$sings[$key] 	= $signs['money'];
	        	$num[$key] 		= $signs['num'];
	        }

	        //合并
	       	$a = array(ids=>$otm);
			$b = array (names=>$tuyt);
			$c = array (money=>$sings);
			$d = array (num=>$num);
			$test = array("a"=>ids,"b"=>names,"c"=>money,"d"=>num);
			$result = array();
			
			for($i=$aa;$i<=$bb;$i++){
			    foreach($test as $key=>$value){
			        $result[$i][$value] = ${$key}[$value][$i];
			    }
			}

			$this->ajaxReturn(array('status'=>1,'info'=>'请求成功！','result'=>$result));
		}
	}
	
}
?>