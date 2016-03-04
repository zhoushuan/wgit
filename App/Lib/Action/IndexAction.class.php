<?php
// 本文档自动生成，仅供测试运行
class IndexAction extends Action
{
    /**
    +----------------------------------------------------------
    * 默认操作
    +----------------------------------------------------------
    */
    public function index()
    {
        header("Content-type: text/html; charset=utf-8"); 
		$db = D('me');
		$l = $db->select();
		
		$count = count($l);
		import("ORG.Util.Page");
		$p = new Page($count, 20);
		$page = $p->show();
		$list = $db->order('id ASC')->limit($p->firstRow.','.$p->listRows)->select();
		
		if($_POST)
		{
			$date['name'] = $_POST['name'];
			$date['tel'] = $_POST['tel'];
			$date['message'] = $_POST['message'];
			$date['add_time'] = time();
			
			if(empty($date['name']))
			{
				echo "<script>alert('提交失败，姓名不能为空！')</script>";
			}elseif(strlen($date['tel'])!=11)
			{
				echo "<script>alert('提交失败，手机号不正确！')</script>";
			}elseif(strlen($date['message'])<10)
			{
				echo "<script>alert('提交失败，祝福语不能为空或少于10个字符！')</script>";
			}else
			{
				if($db->create())
				{
					if($db->add($date))
					{
						$_SESSION['mess'] = $date['message'];
						$this->assign('num',$count);
						$this->assign('contents',$_SESSION['mess']);
						$this->success('非常感谢您的祝福，点击分享，让您的祝福传达给更多的人知晓！');
                                
					}else
					{
						echo "<script>alert('提交失败！')</script>";
					}
				}else
				{
					echo "<script>alert('提交失败！')</script>";
				}
			}
		}
		
		
		$this->assign('num',$count);
		$this->assign('list',$list);
		$this->assign('page', $page);
	
		$this->display();
    }
	

	
}
?>