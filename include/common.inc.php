<?php 
	if (!function_exists('dbRs')) {
		die("Please Check Real Lib inclusion.");
		function dbRs($a="",$b="",$c="") {}
		function dbRow($a="",$b="",$c="") {}
		function dbAr($a="",$b="",$c="") {}
		function dbQuery($a="",$b="",$c="") {}
		function insertTag($a="",$b="",$c="") {}
		function insertTagAndNotify($a="",$b="",$c="") {}
		function screenMessage($a="",$b="",$c="") {}
		function safe($a="",$b="",$c="") {}
		function GetSQLValueString($a="",$b="",$c="") {}
		function generatePagin($pageNo, $base, $queryVariableName, $totalPages){}
		function cacheVoid($key){}
		function cacheGet($key){}
		function timeago($referencedate=0, $timepointer='', $measureby=''){}
		function prevURL(){}
		function getIP(){}
		function decrypt($a=""){}
		function useMoney($a="",$b=""){}
		function addMoney($a="",$b=""){}
		function cacheSet($a="",$b=""){}
		function cacheValid($a="",$b=""){}
		function cacheGet($a="",$b=""){}
		function sendNotification($a="",$b=""){}
		function sendNotifications($a="",$b=""){}
	}
	function convertMoney($amount) {
		
		$len = strlen($amount);
		
		if($len > 2){
			$strcopper = substr($amount, $len-2, 2);
			}else{
			$strcopper = $amount;
			return $strcopper."銅";
		}
		
		if($len < 5){
			$strsilver = substr($amount, 0, $len-2);
			return $strsilver."銀 ".$strcopper."銅";
			}else{
			$strsilver = substr($amount, $len-4, 2);
			$strgold = substr($amount, 0, $len-4);
			return $strgold."金 ".$strsilver."銀 ".$strcopper."銅";
		}
		
	}
	
	function parsePicurl($picurl){
		global $isMobile;
		if($isMobile){
			$width = 320;
			$height = 300;
			
			}else{
			$width = 680;
			$height = 600;
		}
		$picurl = htmlspecialchars($picurl);
		if(strtolower(substr($picurl,0,4)) == "http"){
			$button = "<a href='{$picurl}' title='開啟路徑' class='btn btn-default btn-sm' target='_blank'><span class='glyphicon glyphicon-folder-open'></span> 在新視窗開啟</a><br />";
			switch(strtolower(substr($picurl,-3,3))){
				case "pdf":
				if($isMobile){
					echo "打開PDF: <a href='{$picurl}'>{$picurl}</a>";
					}else{
					$container_id=mt_rand();
					
					echo "<a class='btn btn-default btn-sm' onclick='$(\"#pdf{$container_id}\").attr(\"src\",\"http://docs.google.com/gview?url={$picurl}&amp;embedded=true\");$(\"#pdfct{$container_id}\").show();'>載入PDF: {$picurl}</a>";
					echo "<div class='embed_container125' id='pdfct{$container_id}' style='display:none'><div class='embed_picurl'>";
					echo "<iframe id='pdf{$container_id}' style='border:0' width='100%' height='100%'></iframe>";
					echo "</div></div>{$button}";
				}
				
				break;
				case "jpg":
				case "gif":
				case "png":
				case "bmp":
				echo "<img src='{$picurl}' class='bbcode_img' alt='attachment' />{$button}";
				break;
				case "mp3":
				echo "<object type='application/x-shockwave-flash' data='/players/mediaplayer.swf' style='max-width:{$width}px;height:20px'><param name='wmode' value='transparent' /><param name='movie' value='{$picurl}' /><param name='flashvars' value='&file={$picurl}&autostart=false&repeat=none' /></object>{$button}";
				break;
				default:
				echo "<div class='embed_container75'><div class='embed_picurl'>";
				echo "<iframe  width='100%' height='100%' src=\"https://www.youtube.com/embed/{$picurl}\" frameborder=\"0\" allowfullscreen></iframe>";
				echo "</div></div>";
			}
			
		}
		
	}
	
	function buildhome(){
		static $id = 0;
		$id++; 
		return "<a href=\"#\" onclick=\"dropdown('forumlistlink{$id}','templatecode/forumlist.php','0 20',300);\" id=\"forumlistlink{$id}\" style=\"text-decoration:none;font-size:bold\">+ </a><a href='/' style='font-weight:bold'>RealForum</a>";
	}
	
	function buildNav($arrAll){
		return "<strong>".buildhome() ." &raquo; ".implode(" &raquo; ",$arrAll)."</strong>";
	}
	
	function getAge( $p_strDate ) {
		list($Y,$m,$d)    = explode("-",$p_strDate);
		$years            = date("Y") - intval($Y);
		
		
		if( date("md") < $m.$d ) { $years--; }
		return $years;
	}
	
	function getImageFromGoogle($keyword){
		$keyword = urlencode($keyword);
		$link = "http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q={$keyword}&userip=".getIP();
		$arr = json_decode(file_get_contents($link),true);
		return $arr['responseData']['results'];
		
	}
	
	
	
	
	
	function modRank($fid){
		global $gId;
		$rank = 0;
		$chkarr = dbAr("SELECT rank, ownerid FROM zf_admin WHERE fid = $fid");
		foreach($chkarr as $row){
			if($row['ownerid'] == $gId){$rank = $row['rank'];}
		}
		return $rank;
	}
	function boardSelect($return = false, $default=NULL){
		$forums = dbAr("SELECT * FROM zf_contenttype ORDER BY `order` ASC, `postcount` DESC");
		$cates = dbAr("SELECT * FROM zf_cate ORDER BY `order`");
		
		foreach($cates as $cate) {
			$str .= "<optgroup label='＞{$cate['name']}'>";
			foreach($forums as $forum) {
				if($forum['cate']==$cate['id']){
					
					$selected =($default == $forum['id'])?"selected":"";
					
					$str .= "<option value='{$forum['id']}' {$selected}>".htmlspecialchars($forum['name'])."</option>";
					
				}
			}
			$str .= "</optgroup>";
		}
		if($return == true){
			return $str;
			}else{
			echo $str;
		}
	}
	
	function postnum2rank($postnum){
		return floor(pow($postnum,0.5)) + 1;
	}
	function rank2postnum($rank){
		return ceil(pow($rank - 1,1/0.5));
	}
	function google_search_api($args, $referer = 'http://realforum.zkiz.com', $endpoint = 'web'){
		
		$cachekey = "google_{$args['q']}";
		if (cacheValid($cachekey)) {
			$url = "http://ajax.googleapis.com/ajax/services/search/".$endpoint;
			
			if ( !array_key_exists('v', $args) )
			$args['v'] = '1.0';
			
			$url .= '?'.http_build_query($args, '', '&');
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// note that the referer *must* be set
			curl_setopt($ch, CURLOPT_REFERER, $referer);
			$body = curl_exec($ch);
			curl_close($ch);
			//decode and return the response
			$arr = json_decode($body);
			
			cacheSet($cachekey,$arr);
		}
		$arr = cacheGet($cachekey);
		
		return $arr->responseData->results;
	}
	
	
	
	function gId2rank($gId=0){
		if($gId == 9){return "系統主任";}
		if($gId < 9 && $gId > 1){return "系統輔導員";}
		if($gId == 1){return "普通會員";}
		if($gId == 0){return "訪客";}
	}
	
	
	
	function template($str){
		global $isMobile;
		
		$templatecode_path =  dirname(__FILE__)."/../templatecode";
		if($isMobile){
			//return "$templatecode_path/mobile_$str.php";
		}
		if($_COOKIE['rf_template']=="mobile"){
			return "$templatecode_path/mobile_$str.php";
		}
		return file_exists("$templatecode_path/normal_$str.php")?"$templatecode_path/normal_$str.php":"$templatecode_path/$str.php";
		
	}
	
	
	function updateThreadTags($tag,$tid){
		global $conn;
		if($tag == ''){return false;}
		$tag = properCase($tag);
		if(is_numeric($tag) && strlen($tag)<4){$tag = sprintf("%04d", $tag);}
		$tag = mysqli_real_escape_string($conn,$tag);
		
		$arrTags = getTags($tid);
		
		if($arrTags && in_array($tag,$arrTags)){
			//print_r($now_tags);
			return $arrTags;
			}else{
			$arrTags[]=$tag;
			insertTag($tag,$tid,1);
		}
		
		return $arrTags;
	}