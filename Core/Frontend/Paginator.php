<?php
/*
 * PHP Pagination Class
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 1.0
 * @date October 20, 2012
 */

namespace Core\Frontend;

class Paginator{
    /**
	 * @var numeric
	*/
	private $_itemPerPage;
	/**
	 * set get parameter for fetching the page number
	 *
	 * @var string
	*/
	private $_instance;
	private $_page;
	private $_limitPost;
	/**
	 * set the total number of items in database.
	 *
	 * @var numeric
	*/
	private $_totalRows = 0;
	/**
	 * set custom css classes for additional flexibility
	 *
	 * @var sting
	*/
	private $_customCSS;
	/**
	 *  __construct
	 *
	 *  pass values when class is istantiated
	 *
	 * @param numeric  $_itemPerPage  sets the number of iteems per page
	 * @param numeric  $_instance sets the instance for the GET parameter
	 */
	public function __construct($itemPerPage, $instance, $totalRows, $customCSS = ''){
		$this->_instance = $instance;
		$this->_itemPerPage = $itemPerPage;
		$this->set_instance();
		$this->_totalRows = $totalRows;
		$this->_customCSS = $customCSS;
	}
	/**
	 * get_startPost
	 *
	 * creates the starting point for limiting the dataset
	 * @return numeric
	*/
	public function get_startPost(){
		return ($this->_page - 1) * $this->_itemPerPage;
	}
	/**
	 * set_instance
	 *
	 * sets the instance parameter, if numeric value is 0 then set to 1.
	*/
	private function set_instance(){
		if(!isset($_GET[$this->_instance]) || $_GET[$this->_instance] <= 0) {
			$this->_page = 1;
		} else {
			$this->_page = (int) $_GET[$this->_instance];
		}
	}
	/**
	 * set_total
	 *
	 * Collect a numberic value and assigns it to the totalRows
	*/
	public function set_total($totalRows){
		$this->_totalRows = $totalRows;
	}
	/**
     	* get_limit_keys
     	*
     	* returns an array of the offset and limit returned on each call
     	*
     	* @return array
    	*/
    	public function get_limit_keys(){
        	return ['offset' => $this->get_startPost(), 'limit' => $this->_itemPerPage];
    	}
        /**
         * renderPagination
         *
         * create the html links for navigating through the dataset
         *
         * @var srting $path optionally set the path for the link
         * @var srting $ext optionally pass in extra parameters to the GET
         * @return string returns the html menu
        */
	public function renderPagination($path='?', $ext=null)
	{
	    $adjacents = "2";
	    $prev = $this->_page - 1;
	    $next = $this->_page + 1;
	    $lastpage = ceil($this->_totalRows/$this->_itemPerPage);
	    $lpm1 = $lastpage - 1;
	    $pagination = "";
		if($lastpage > 1)
		{
		    $pagination .= "<ul class='pagination justify-content-center".$this->_customCSS."'>";
		    // Previous button
			if ($this->_page > 1)
			    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=$prev"."$ext'>Previous</a></li>";
			else
			    $pagination.= "<li class='page-item disable' ><a class='page-link'>Previous</a></li>";
			// Show page link
			if ($lastpage < 7 + ($adjacents * 2)){
				for ($counter = 1; $counter <= $lastpage; $counter++){
				if ($counter == $this->_page)
				    $pagination.= "<li class='page-item active'><a class='page-link'>$counter</a></li>";
				else
				    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=$counter"."$ext'>$counter</a></li>";
				}
			}
			elseif ($lastpage > 5 + ($adjacents * 2)){
				if($this->_page < 1 + ($adjacents * 2)){
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
						if ($counter == $this->_page)
						    $pagination.= "<li class='page-item active' ><a class='page-link'>$counter</a></li>";
						else
						    $pagination.= "<li class='page-item'><a class='page-link' href='{$path}{$this->_instance}={$counter}{$ext}'>{$counter}</a></li>";
					}
				    $pagination.= "...";
				    $pagination.= "<li class='page-item'><a class='page-link' href='{$path}{$this->_instance}={$lpm1}{$ext}'>{$lpm1}</a></li>";
				    $pagination.= "<li class='page-item'><a class='page-link' href='{$path}{$this->_instance}={$lastpage}{$ext}'>{$lastpage}</a></li>";
				}
				elseif($lastpage - ($adjacents * 2) > $this->_page && $this->_page > ($adjacents * 2)){
				    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=1"."$ext'>1</a></li>";
				    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=2"."$ext'>2</a></li>";
				    $pagination.= "...";
					for ($counter = $this->_page - $adjacents; $counter <= $this->_page + $adjacents; $counter++)
					{
					if ($counter == $this->_page)
					    $pagination.= "<li class='page-item active' ><a class='page-link'>$counter</a></li>";
					else
					    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=$counter"."$ext'>$counter</a></li>";
					}
					    $pagination.= "..";
					    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=$lpm1"."$ext'>$lpm1</a></li>";
					    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=$lastpage"."$ext'>$lastpage</a></li>";
				}
				else{
				    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=1"."$ext'>1</a></li>";
				    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=2"."$ext'>2</a></li>";
				    $pagination.= "..";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++){
					if ($counter == $this->_page)
					    $pagination.= "<li class='page-item active' ><a class='page-link'>$counter</a></li>";
					else
					    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=$counter"."$ext'>$counter</a></li>";
					}
				}
			}
			if ($this->_page < $counter - 1)
			    $pagination.= "<li class='page-item'><a class='page-link' href='".$path."$this->_instance=$next"."$ext'>Next</a></li>";
			else
			    $pagination.= "<li class='page-item disable' ><a class='page-link'>Next</a></li>";
			    $pagination.= "</ul>\n";
		}
	return $pagination;
	}
}