<?php
class PageModel extends CommonModel {
	
	public function show($count,$targetType,$pagesize,$pageNumShown,$page){
		/*
		*count	总条数         
		*targetType	navTab或dialog，用来标记是navTab上的分页还是dialog上的分页
		*pagesize	 每页显示多少条    
		*pageNumShown	 页标数字多少个
		*page	当前是第几页
		*/
		$info = "<div class='panelBar'><div class='pages'><span>共".$count."条</span></div><div class='pagination' targetType=".$targetType." totalCount=".$count." numPerPage=".$pagesize." pageNumShown=".$pageNumShown." currentPage=".$page."></div></div>";
		return $info;
	}

}
?>