<?php
//mail("abbychau@gmail.com","TESTING","TESTING CONTENT\nTEST","Content-type:text/plain");
exit;
include("Connections/zkizblog.php");
include("include/common.inc.php");
include(template('header'));
?>
<div style="width:600px;height:400px">
<embed src="http://video.appledaily.com.hk/admedia/20141002/20141002_add_c12_w.mp4"></embed>
</div>
<? include(template('footer')); exit; ?>
<?
$RFG['max_allow_at'] = 10;

header("content-type:text/plain");
$message="你好 @abbychau @gloomysunday";
preg_match_all("/@([^\r\n]*?)\s/i", $message.' ', $tmpAtList);
$arrAtList = array_unique($tmpAtList[1]);
$arrAtList = array_slice($arrAtList,0,$RFG['max_allow_at']);
if(!empty($arrAtList)){
sendNotifications($arrAtList,"","{$my['id']}在<strong>{$title}</strong>提及了你。","{$g_domain}/thread.php?tid={$tid}&amp;floorid={$floorid}");
}
print_r($atlist_tmp);
exit;
$rslt = getImageFromGoogle("車 血 紅色");
print_r($rslt);
exit;

$myset = dbAr("SELECT id, title, tags
FROM  `zf_contentpages` 
WHERE  `type` = 128");

foreach($myset as $v){
	preg_match_all('~[\d]{4}~', $v['title'], $matches);
	$tags = getTags($v['id']);
	//print_r($tags);
	///print_r($matches);

	foreach($matches[0] as $match){
		
		if(is_array($tags)){
			foreach($tags as $tag){
				if((isset($_GET['all']) || is_numeric($tag)) && $match != $tag){
					if(!isset($_GET['eliminate']) || !is_array($arr[$tag]) || !in_array($match,$arr[$tag])){
						$arr[$match][] = $tag;
					}
				}
			}
		}
		
		if(is_array($arr[$match])){
			$arr[$match] = array_unique($arr[$match]);
		}
	}
}
//print_r($arr);

foreach($arr as $x => $y){
	foreach ($y as $i => $j){
		if(!in_array($j,array("關係","恆生","中國","專區","國際","討論","投資","科技","基金")) && strlen($j)>2 && strlen($j)<20){
			echo "$x , $j , \n";
		}
	}
}
exit;
/*
$emptyArt = dbAr("SELECT * FROM `zf_reply` WHERE fid = 168 AND isfirstpost = 0");

foreach($emptyArt as $v){
$titles = explode("\n",$v['content']);
$name = dbRs("SELECT title FROM zf_contentpages WHERE id = (SELECT tid FROM `zf_reply` WHERE id = {$v['id']})");
$title = "[$name]".str_replace("'","",preg_replace('/\[(.*)\]/','',$titles[0]));
//die($title);
dbQuery("INSERT INTO `zf_contentpages` (`id`, `title`, `tags`, `views`, `isshow`, `isdigest`, `special`, `type`, `commentnum`, `tpraise`, `donation`, `lastid`, `authorid`, `lastdatetime`) VALUES (NULL, '$title', 'a:1:{i:0;s:6:\"$name\";}', '11', '1', '0', '0', '168', '0', '0', '0', '14', '14', '{$v['timestamp']}')");
dbQuery("UPDATE `zf_reply` SET isfirstpost = 1, tid = LAST_INSERT_ID() WHERE id = {$v['id']}");
if(++$i > 500){die("success for 500");}
}
*/



/*

    <h1>Connect JavaScript - jQuery Login Example</h1>
    <div>
      <button id="login">Login</button>
      <button id="logout">Logout</button>
      <button id="disconnect">Disconnect</button>
    </div>
    <div id="user-info" style="display: none;"></div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

    <div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js"></script>
    <script>
      // initialize the library with the API key
      FB.init({ apiKey: 'b152912a4d2a09ed473c8bbb07344e5e' });

      // fetch the status on load
      FB.getLoginStatus(handleSessionResponse);

      $('#login').bind('click', function() {
        FB.login(handleSessionResponse);
      });

      $('#logout').bind('click', function() {
        FB.logout(handleSessionResponse);
      });

      $('#disconnect').bind('click', function() {
        FB.api({ method: 'Auth.revokeAuthorization' }, function(response) {
          clearDisplay();
        });
      });

      // no user, clear display
      function clearDisplay() {
        $('#user-info').hide('fast');
      }

      // handle a session response from any of the auth related calls
      function handleSessionResponse(response) {
        // if we dont have a session, just hide the user info
        if (!response.session) {
          clearDisplay();
          return;
        }

        // if we have a session, query for the user's profile picture and name
        FB.api(
          {
            method: 'fql.query',
            query: 'SELECT name, pic FROM profile WHERE id=' + FB.getSession().uid
          },
          function(response) {
            var user = response[0];
            $('#user-info').html('<img src="' + user.pic + '">' + user.name).show('fast');
          }
        );
      }
    </script>
*/

/*
	//if($my['facebook']!=""){
	$title= "sdf";
		require('../facebook/facebook.php');
		$facebook = new Facebook(array(
		  'appId'  => '255045087298',
		  'secret' => 'd81e5a4fe63162338ed41b6783816e24',

  'cookie' => true // enable optional cookie support
		));
		
		
	//}
*/
/*
require("../share/connection/phpFlickr.php");
$f = new phpFlickr("9a7ccb384e5c9c82b16010caafae862b","30875ab3eaf8b929");
//$f->auth("write");

$f->setToken("72157626343993651-d5f706a8dbd6d833");
$id = $f->sync_upload("8831.gif");
die($id);
//key：
//9a7ccb384e5c9c82b16010caafae862b
//密鑰：
//30875ab3eaf8b929
*/
include(template('header'));
?>

<script>
FB.ui({method: 'apprequests', message: 'I am testing fb.ui.', data: '<?=$gid;?>'});
</script>
<div class="fb-login-button" data-show-faces="true" data-width="500" data-max-rows="1"></div>

<script> 
function MM_openBrWindow(theURL,winName,features) {
  window.open(theURL,winName,features);
}
 
function open_new_win (url) {
newWindow =    window.open(url,"NewMainPageWindow","toolbar=no,width=780,height=550;,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no")
}
</script> 
<?
include(template('footer'));
?>