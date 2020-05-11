<?php
	
	class BBCode {
		var $maxsmilies=20;
		var $searcharray = array();
		var $replacearray = array();
		var $bbcodes = Array();
		
		var $oldPort= array(
		'member' =>'<a href="http://realforum.zkiz.com/m/\\1">\\1</a>',
		'archive' =>'<a href="http://zkiz.com/archive.php?id=\\1">\\1</a>',
		'stock' =>'<a href="http://stock.zkiz.com/query.php?code=\\1">\\1</a>',
		'aa' => '<pre style="font:\'Courier New\', Courier, monospace; line-height:100%;white-space:pre-wrap;margin:0px"></pre>',
		'simg' => '<img src="api/liki.php?url=\\1" />',
		'nico' => '<script type="text/javascript" src="http://ext.nicovideo.jp/thumb_watch/?\\1w=425&h=319"></script>',
		'left' => '<div class="left" style="text-align:left">\\1</div>\n',
		'right' => '<div class="right" style="text-align:right">\\1</div>',
		'center' => '<div class="center" style="text-align:center">\\1</div>',
		'indent' => '<div class="bbcode_indent" style="margin-left:4em">\\1</div>',
		'buzz' => '<iframe src="http://fancy.zkiz.com/buzz.php?id=\\1" style="width:600px; height:800px; border:0"></iframe>',
		'flv' => '<embed type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="600" height="400" src="http://realforum.zkiz.com/players/mediaplayer.swf?file=\\1"></embed>',
		'swf' => '<embed type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="600" height="400" src="\\1"></embed>',
		'mp3' => '<embed type="application/x-shockwave-flash" flashvars="audioUrl=\\1" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best"></embed>',
		'audio' => '<audio src="\\1" controls="controls">你的瀏覽器不支援音效標籤, 請用Chrome6 或 Firefox3.6 以上觀看。</audio>',
		'youtube' => '<div class="embed_container75"><div class="embed_picurl"><object type="application/x-shockwave-flash" data="http://www.youtube.com/v/\\1" width="100%" height="100%"><param name="wmode" value="transparent" /><param name="movie" value="http://www.youtube.com/v/\\1" /></object></div></div>',
		'draw' => '<embed type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="600" height="246" src="http://realforum.zkiz.com/images/fdshow.swf?code=\\1"></embed>',
		'emot'=>'<img src="images/smileys/\\1.gif" alt="smiley" />',
		'syntax'=>'<pre class="prettyprint">\\1</pre>',
		'code'=>'<pre class="prettyprint">\\1</pre>'
		);
		
		
		
		function __construct(){
			foreach($this->oldPort as $k => $v){
				$this->bbcodes['searcharray'][]='/\\['.$k.'](.+?)\\[\\/'.$k.'\\]/is';
				$this->bbcodes['replacearray'][]=$v;
			}
		}
		
		function getRBResult($content){
			$params=explode("/",$content);
			$id = intval($params[4]);
			
			$div1 = "<div class=\"bbcode_quote\"><div class=\"bbcode_quote_head\">RealBlog文章(連結:<a href='$content'>$content</a>)</div><div class=\"bbcode_quote_body\">";
			$div2 = "</div></div>";
			$main = dbRs("SELECT content FROM zb_contentpages WHERE id = '$id'");

			return $div1.$main.$div2;
			
			
		}
		
		
		function parseurl($message) {
			return preg_match("/\[code\].+?\[\/code\]/is", $message) ? $message :
			substr(preg_replace(	array(
			"/(?<=[^\]a-z0-9-=\"'\\/])(http:\/\/[a-z0-9\/\-_+=.~!%@?#%&;:$\\()|]+\.(jpg|gif|png|bmp))/i",
			"/(?<=[^\]\)a-z0-9-=\"'\\/])((https?|ftp|gopher|news|telnet|rtsp|mms|callto):\/\/|www\.)([a-z0-9\/\-_+=.~!%@?#%&;:$\\()|]+)/i",
			"/(?<=[^\]\)a-z0-9\/\-_.~?=:.])([_a-z0-9-+]+(\.[_a-z0-9-+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))/i"
			), array(
			"[img]\\1[/img]",
			"[url]\\1\\3[/url]",
			"[email]\\0[/email]"
			), ' '.$message), 1);
		}
		
		function parsetable($width, $message) {
			$width = substr($width, -1) == '%' ? (substr($width, 0, -1) <= 98 ? $width : '98%') : ($width <= 560 ? $width : '98%');
			return '<table '.
			($width == '' ? NULL : 'width="'.$width.'" ').
			'align="center" class="table table-default">'.
			str_replace(array('[tr]', '[td]', '[/td]', '[/tr]', '\\"'), array('<tr>', '<td>', '</td>', '</tr>', '"'), preg_replace("/\[td=(\d{1,2}),(\d{1,2})(,(\d{1,3}%?))?\]/is", '<td colspan="\\1" rowspan="\\2" width="\\4">', $message)).
			'</table>';
		}
		
		function parse($message) {
			
			
			
			if(!empty($this->smilies) && is_array($this->smilies)) {
				$message = preg_replace($this->smilies['searcharray'], $this->smilies['replacearray'], $message, $this->maxsmilies);
			}
			
			
			
			if(empty($this->searcharray)) {
				$this->searcharray['bbcode_regexp'] = array(
				
				"/\[url=www.([^\[\"']+?)\](.+?)\[\/url\]/is",
				"/\[url=(https?|ftp|gopher|news|telnet|rtsp|mms|callto|ed2k){1}:\/\/([^\[\"']+?)\](.+?)\[\/url\]/is",
				"/\[email\]\s*([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\s*\[\/email\]/i",
				"/\[email=([a-z0-9\-_.+]+)@([a-z0-9\-_]+[.][a-z0-9\-_.]+)\](.+?)\[\/email\]/is",
				"/\[color=([^\[\<]+?)\]/i",

				"/\[size=(\d+(px|pt|in|cm|mm|pc|em|ex|%)+?)\]/i",
                "/\[size=(\d+?)\]/i",
				"/\[font=([^\[\<]+?)\]/i",
				"/\[align=([^\[\<]+?)\]/i",
				
				"/\[quote floor='([0-9]+)'\]/i",
				"/\[quote floor=([0-9]+)\]/i",
				"/\[quote floor=([0-9]+) by='(.+?)'\]/i",
				"/\[back=(.+?)\]/i",
				"/\[@(.+?)\]/i"
				);
				$this->replacearray['bbcode_regexp'] = array(
				"<a href=\"http://www.\\1\" target=\"_blank\">\\2</a>",
				"<a href=\"\\1://\\2\" target=\"_blank\">\\3</a>",
				"<a href=\"mailto:\\1@\\2\">\\1@\\2</a>",
				"<a href=\"mailto:\\1@\\2\">\\3</a>",
				"<font color=\"\\1\">",

				"<font style=\"font-size: \\1\">",
                "<font size=\"\\1\">",
				"<font face=\"\\1\">",
				"<p align=\"\\1\">",
				
				"<blockquote><a onclick=\"jump(\\1)\">\\1樓</a>提及<hr />",
				"<blockquote><a onclick=\"jump(\\1)\">\\1樓</a>提及<hr />",
				"<blockquote><a href=\"/m/\\2\">\\2</a>在<a onclick=\"jump(\\1)\">\\1樓</a>提及<hr />",
				"<span style='background-color:\\1'>",
				"<a href='/m/\\1'>@\\1</a>"
				);
				

				
				$this->searcharray['bbcode_regexp'] = array_merge($this->searcharray['bbcode_regexp'], $this->searcharray['bbcode_regexp']);
				$this->replacearray['bbcode_regexp'] = array_merge($this->replacearray['bbcode_regexp'], $this->replacearray['bbcode_regexp']);
				
				$this->searcharray['bbcode_str'] = array('[s]','[/s]','[hr]','[br]',
				'[sup]','[/sup]','[sub]','[/sub]',
				'[/color]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]',
				'[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
				'[list=A]', '[*]', '[/list]', '[indent]', '[/indent]','[quote]','[/quote]','[/back]',
				'[table]','[tr]','[td]','[/table]','[/tr]','[/td]'
				);
				
				$this->replacearray['bbcode_str'] = array('</strike>', '</strike>','<hr />','<br />',
				'<sup>','</sup>','<sub>','</sub>',
				'</font>', '</font>', '</font>', '</p>', '<b>', '</b>', '<i>',
				'</i>', '<u>', '</u>', '<ul>', '<ol type=1>', '<ol type=a>',
				'<ol type=A>', '<li>', '</ul></ol>', '<blockquote>', '</blockquote>','<blockquote>','</blockquote>','</span>',
				'<table>','<tr>','<td>','</table>','</tr>','</td>'
				);
			}
			$message = $this->parseurl($message);
			//preg phrase
			$message = preg_replace(
			array_merge($this->searcharray['bbcode_regexp'], $this->bbcodes['searcharray']),
			array_merge($this->replacearray['bbcode_regexp'], $this->bbcodes['replacearray']),
			$message);
			
			//str phrase
			$message = str_replace($this->searcharray['bbcode_str'], $this->replacearray['bbcode_str'],$message);
			global $isReplied,$isMobile,$isBought,$isLog,$isLiked;
			
			//BUY
			if($isLog == true){
				$message = preg_replace("/\[login\]\s*(.+?)\s*\[\/login\]/is",
				"<div class=\"bbcode_quote\"><div class=\"bbcode_quote_head\">你經已登入，因此可以觀看下面內容</div>\n<div class=\"bbcode_quote_body\">\\1</div></div>",
				$message);
			}else{
				$message = preg_replace("/\[login\](.+?)\[\/login\]/is", "<div class=\"bbcode_quote\"><div class=\"bbcode_quote_head\">這部份內容己被隱藏，登入後即可觀看。</div></div>", $message);
			}


			//HIDE/FBHIDE
			if($isReplied || $isLiked){
				$message = preg_replace("/\[hide\]\s*(.+?)\s*\[\/hide\]/is",
				"\n<div class=\"bbcode_quote\">\n<div class=\"bbcode_quote_head\">你經已回覆，因此可以觀看下面內容</div>\n<div class=\"bbcode_quote_body\">\\1</div>\n</div>\n",
				$message);
				$message = preg_replace("/\[fbhide\]\s*(.+?)\s*\[\/fbhide\]/is",
				"\n<div class=\"bbcode_quote\">\n<div class=\"bbcode_quote_head\">你經已回覆/讚好，因此可以觀看下面內容</div>\n<div class=\"bbcode_quote_body\">\\1</div>\n</div>\n",
				$message);
			}else{
				$normal_replace = "<div class=\"bbcode_quote\"><div class=\"bbcode_quote_head\">這部份內容己被隱藏，登入並回覆後即可觀看。</div></div>";
				$fbhide_replace = "<div class=\"bbcode_quote\" style='z-index:4'><div class=\"bbcode_quote_head\">這部份內容己被隱藏，讚好或分享後即可觀看。</div><div><div class='fbhidecontainer' style='height:150px'></div><div class='realcontent' style='display:none'>\\1</div></div></div>";
				$message = preg_replace("/\[hide\](.+?)\[\/hide\]/is", $fbhide_replace , $message);
				$message = preg_replace("/\[fbhide\](.+?)\[\/fbhide\]/is", $fbhide_replace, $message);
			}
			//BUY
			if($isBought == true){
				$message = preg_replace("/\[sell\]\s*(.+?)\s*\[\/sell\]/is",
				"<div class=\"bbcode_quote\"><div class=\"bbcode_quote_head\">你經已購買帖子，因此可以觀看下面內容</div>\n<div class=\"bbcode_quote_body\">\\1</div></div>",
				$message);
			}else{
				$message = preg_replace("/\[sell\](.+?)\[\/sell\]/is", "<div class=\"bbcode_quote\"><div class=\"bbcode_quote_head\">這部份內容己被隱藏，購買帖子後即可觀看。</div></div>", $message);
			}
			
			//PDF
			if($isMobile){
				$message = preg_replace("/\[pdf\]\s*(.+?)\s*\[\/pdf\]/is",
			"\n<a target='_blank' href='\\1'><strong>開啟PDF: </strong>\\1</a>",
			$message);
			}else{
				$message = preg_replace("/\[pdf\]\s*(.+?)\s*\[\/pdf\]/is",
			"<iframe src='http://docs.google.com/gview?url=\\1'style='width:600px; height:600px; border:0'></iframe>",
			$message);
			}
			
			
			//REPLACE IMG
			$this->searcharray['callback_replace'] = array(
			
				"/\s*\[table(=(\d{1,3}%?))[,none]*?\][\n\r]*(.+?)[\n\r]*\[\/table\]\s*/is",
				"/\[realblog\](.+?)\[\/realblog\]/i",
				"/\[url\]\s*(www.|https?:\/\/|ftp:\/\/|gopher:\/\/|news:\/\/|telnet:\/\/|rtsp:\/\/|mms:\/\/|callto:\/\/|ed2k:\/\/){1}([^\[\"']+?)\s*\[\/url\]/i",
				"/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is",
				"/\[img=(\d{0,3})[x|\,](\d{0,3})[x|\,](\w{0,10})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is",
				"/\[img=(\d{0,3})[x|\,](\w{0,10})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/is"
			);
			$this->replacearray['callback_replace'] = array(
				function($v){return $this->parsetable($v[2], $v[3]);},
				function($v){return $this->getRBResult($v[1]);},
				function($v){return $this->cuturl("{$v[1]}{$v[2]}");},
				function($v){return $this->bbcodeurl($v[1], "<img class='bbcode_img' src='%s' border='0' alt='' />");},
				function($v){return $this->bbcodeurl($v[3], "<img class='bbcode_img' src='%s' border='0' width='{$v[1]}' height='{$v[2]}' align='{$v[3]}' alt='' />");},
				function($v){return $this->bbcodeurl($v[3], "<img class='bbcode_img' src='%s' border='0' width='{$v[1]}' align='{$v[2]}' alt='' />");}
				
			);
			foreach(range(0,sizeof($this->searcharray)) as $k){
				$message = preg_replace_callback(
					$this->searcharray['callback_replace'][$k], 
					$this->replacearray['callback_replace'][$k], 
					$message
				);
			}

			
			return nl2br(str_replace(array("\t",'    ', '   '), '&nbsp;&nbsp;', $message));
		}
		
		function cuturl($url) {
			$length = 65;
			$urllink = "<a href=\"".(substr(strtolower($url), 0, 4) == 'www.' ? "http://$url" : $url).'" target="_blank">';
			if(strlen($url) > $length) {
				$url = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, - intval($length * 0.3));
			}
			$urllink .= $url.'</a>';
			return $urllink;
		}
		
		function bbcodeurl($url, $tags) {
			if(!preg_match("/<.+?>/s", $url)) {
				if(!in_array(strtolower(substr($url, 0, 6)), array('http:/', 'ftp://', 'rtsp:/', 'mms://'))) {
					$url = 'http://'.$url;
				}
				return str_replace(array('submit', 'logging.php'), array('', ''), sprintf($tags, $url, addslashes($url)));
				} else {
				return '&nbsp;'.$url;
			}
		}
	}
	