<?php 
	require_once('Connections/zkizblog.php'); 
	require_once('include/common.inc.php'); 
	
	if (!$isLog){screenMessage("錯誤","請先登入","http://members.zkiz.com/login.php");}
	
/**
 * Balances tags of string using a modified stack.
 *
 * @since 2.0.4
 *
 * @author Leonard Lin <leonard@acm.org>
 * @license GPL
 * @copyright November 4, 2001
 * @version 1.1
 * @todo Make better - change loop condition to $text in 1.2
 * @internal Modified by Scott Reilly (coffee2code) 02 Aug 2004
 *		1.1  Fixed handling of append/stack pop order of end text
 *			 Added Cleaning Hooks
 *		1.0  First Version
 *
 * @param string $text Text to be balanced.
 * @return string Balanced text.
 */
function force_balance_tags( $text ) {
    $tagstack = array();
    $stacksize = 0;
    $tagqueue = '';
    $newtext = '';
    // Known single-entity/self-closing tags
    $single_tags = array( 'area', 'base', 'basefont', 'br', 'col', 'command', 'embed', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param', 'source' );
    // Tags that can be immediately nested within themselves
    $nestable_tags = array( 'blockquote', 'div', 'object', 'q', 'span' );

    // WP bug fix for comments - in case you REALLY meant to type '< !--'
    $text = str_replace('< !--', '<    !--', $text);
    // WP bug fix for LOVE <3 (and other situations with '<' before a number)
    $text = preg_replace('#<([0-9]{1})#', '&lt;$1', $text);

    while ( preg_match("/<(\/?[\w:]*)\s*([^>]*)>/", $text, $regex) ) {
        $newtext .= $tagqueue;

        $i = strpos($text, $regex[0]);
        $l = strlen($regex[0]);

        // clear the shifter
        $tagqueue = '';
        // Pop or Push
        if ( isset($regex[1][0]) && '/' == $regex[1][0] ) { // End Tag
            $tag = strtolower(substr($regex[1],1));
            // if too many closing tags
            if( $stacksize <= 0 ) {
                $tag = '';
                // or close to be safe $tag = '/' . $tag;
            }
            // if stacktop value = tag close value then pop
            else if ( $tagstack[$stacksize - 1] == $tag ) { // found closing tag
                $tag = '</' . $tag . '>'; // Close Tag
                // Pop
                array_pop( $tagstack );
                $stacksize--;
            } else { // closing tag not at top, search for it
                for ( $j = $stacksize-1; $j >= 0; $j-- ) {
                    if ( $tagstack[$j] == $tag ) {
                        // add tag to tagqueue
                        for ( $k = $stacksize-1; $k >= $j; $k--) {
                            $tagqueue .= '</' . array_pop( $tagstack ) . '>';
                            $stacksize--;
                        }
                        break;
                    }
                }
                $tag = '';
            }
        } else { // Begin Tag
            $tag = strtolower($regex[1]);

            // Tag Cleaning

            // If it's an empty tag "< >", do nothing
            if ( '' == $tag ) {
                // do nothing
            }
            // ElseIf it presents itself as a self-closing tag...
            elseif ( substr( $regex[2], -1 ) == '/' ) {
                // ...but it isn't a known single-entity self-closing tag, then don't let it be treated as such and
                // immediately close it with a closing tag (the tag will encapsulate no text as a result)
                if ( ! in_array( $tag, $single_tags ) )
                    $regex[2] = trim( substr( $regex[2], 0, -1 ) ) . "></$tag";
            }
            // ElseIf it's a known single-entity tag but it doesn't close itself, do so
            elseif ( in_array($tag, $single_tags) ) {
                $regex[2] .= '/';
            }
            // Else it's not a single-entity tag
            else {
                // If the top of the stack is the same as the tag we want to push, close previous tag
                if ( $stacksize > 0 && !in_array($tag, $nestable_tags) && $tagstack[$stacksize - 1] == $tag ) {
                    $tagqueue = '</' . array_pop( $tagstack ) . '>';
                    $stacksize--;
                }
                $stacksize = array_push( $tagstack, $tag );
            }

            // Attributes
            $attributes = $regex[2];
            if( ! empty( $attributes ) && $attributes[0] != '>' )
                $attributes = ' ' . $attributes;

            $tag = '<' . $tag . $attributes . '>';
            //If already queuing a close tag, then put this tag on, too
            if ( !empty($tagqueue) ) {
                $tagqueue .= $tag;
                $tag = '';
            }
        }
        $newtext .= substr($text, 0, $i) . $tag;
        $text = substr($text, $i + $l);
    }

    // Clear Tag Queue
    $newtext .= $tagqueue;

    // Add Remaining text
    $newtext .= $text;

    // Empty Stack
    while( $x = array_pop($tagstack) )
        $newtext .= '</' . $x . '>'; // Add remaining tags to close

    // WP fix for the bug with HTML comments
    $newtext = str_replace("< !--","<!--",$newtext);
    $newtext = str_replace("<    !--","< !--",$newtext);

    return $newtext;
}
	
	
	if($_POST['advertisement_id']){
		$adv_id = safe($_POST['advertisement_id']);
		$content = safe(strip_tags($_POST['content'],'<p><div><br><span><b><strong><i><a><img>'));
		$content = force_balance_tags($content);
		$adv_price = dbRs("SELECT price FROM zf_advertisement WHERE id = $adv_id");
		
		useMoney($adv_price,$gId);
		
		dbQuery("INSERT INTO `zf_advertisement_record` (`id` ,`advertisement_id` ,`zid` ,`content` ,`create_date`) VALUES (NULL ,  '$adv_id',  '{$my['id']}',  '{$content}', CURRENT_TIMESTAMP);");
	}
	$arr = dbAr("SELECT * FROM zf_advertisement_record ORDER BY id DESC LIMIT 20");
	$advertisementInfo = dbAr("SELECT * FROM zf_advertisement"); //dbAr dbRow dbRs
	$htmltitle = "廣告系統";
	
	function arr2table($arr){
		
		foreach($arr as $row){
			$rows[] = "<tr><td>".implode("</td><td>",$row)."</td></tr>";
		}
		return "<table border='1'>".implode($rows)."</table>";
	}
	
	include(template("header"));
?>
<script>
	function buyAdv(adv_id){
		if(confirm("你確定要買這個廣告位嗎?")){
			$('#adv_id').val(adv_id);
			$('#sendcontent').val($('#content').val());
			$('#adv_form').submit();
		}
	}
</script>
<div class='panel panel-default'>
	<div class='panel-body'>
		<h1>RealForum 廣告系統</h1>
		
		<ol>
			<li>你可以消費壇幣將自己希望表達的信息廣而告之</li>
			<li>發怖後不保證顯示時間, 當下一次有人發怖時即會取代現有的廣告位</li>
			<li>可以使用HTML 來編輯你的廣告, 但只容許使用p,div,br,span,b,strong,i,a,img</li>
		</ol>
		<h3>請輸入你想說的話</h3>
		(支援HTML) eg. &lt;strong&gt;&lt;a href='http://google.com'&gt;我愛abbychau&lt;/a&gt;&lt;/strong&gt;<br />
		<textarea id='content' style='width:100%;height:150px'></textarea>
		
		<h3>請選擇你要買的廣告位</h3>
		
		<form method='post' id='adv_form'>
			<input name='content' id='sendcontent' type='hidden' />
			<input type='hidden' name='advertisement_id' id='adv_id' />
		</form>
		
		<? foreach($advertisementInfo as $v){ ?>
			<button onclick='buyAdv(<?=$v['id'];?>)'><?=$v['name'];?>($<?=$v['price'];?>)</button>
		<? } ?>
		
	</div>
</div>



<hr />


<hr />

<?include(template("footer"));?>