<?
	
	class rfPosts{
		
		public static function newThread($title, $subtitle, $fid, $content, $picurl, $datetime, $ip, $zid, $special=0, $price=0,$tags, $also_subscribe){
			
			global $my,$RFG,$isLog,$gUsername,$gId,$blackwords;
			
			if($title == ""){return -1;}
			
			if($content == ""){return -2; }
			$subtitle = safe(trim($subtitle));
			$content = safe(trim($content));
			$title = safe(trim($title));
			foreach($blackwords as $v){
				if(strstr($title,$v)){
					return -3;
				}
			}
			//die($content);
			if($my['nobj']==1){
				$newPostScore1 = $RFG['newPostScore1']*0.5;
			}else{
				$newPostScore1 = $RFG['newPostScore1'];
			}
			if($gId == $zid){
				$username=$gUsername;
			}else{
				$username = safe(dbRs("SELECT username FROM zf_user WHERE id = $zid"));
			}
			$lastTID = dbQuery("INSERT INTO zf_contentpages (title,subtitle, type, authorusername,authorid,special,create_timestamp) VALUES ('{$title}','{$subtitle}',{$fid},'{$username}',{$zid},{$special},CURRENT_TIMESTAMP)");
			
			dbQuery("INSERT INTO zf_reply (fid, fellowid, content, picurl, datetime, ip, authorid, isfirstpost, price) VALUES ($fid, $lastTID, '$content', '$picurl', '$datetime', '$ip', '$zid', 1, '$price')");
			
			if(trim($subtitle)!=""){
				$newPostScore1 = $newPostScore1 *1.5;
			}
			
			if($isLog){
				dbQuery("UPDATE zf_user SET postnum = postnum + 1, postnum_today = postnum_today+1, score1 = score1 + $newPostScore1 where id = '$zid'");
			}
			dbQuery("UPDATE zf_contenttype SET threadcount = threadcount + 1, datetime = NOW(), lastaid=$zid,lasttid=$lastTID,postcount=postcount+1,lastusername='{$username}',lasttitle='{$title}' WHERE id = {$fid}");
			if($also_subscribe){
				dbQuery("INSERT IGNORE INTO zf_relation SET source_zid = {$zid}, target_zid = {$lastTID}, relation_type = 4");
			}
			
			insertTag($tags?$tags:extractTagsFromString($title),$lastTID,1);
			
			return $lastTID;
		}
		
		public static function isThreadExists($authorid,$title){
			$title = safe($title);
			$authorid = intval($authorid);
			$c = dbRs("SELECT count(1) FROM zf_contentpages WHERE authorid = $authorid AND title = '{$title}'");
			return intval($c)>0;
		}
		
		public static function replyThread($fid, $tid, $pid, $content, $picurl, $datetime, $ip, $zid,$username, $price, $threadAuthorId,$also_subscribe){
			global $my,$RFG,$isLog;
			$username = safe($username);
			$score1AmountGet = mb_strlen($content,'utf8') > 15 ? $RFG['newReplyScore1High'] : $RFG['newReplyScore1Low'];
			
			if($my['nobj']==1){
				$score1AmountGet = $score1AmountGet *0.5;
				$beingRepliedScore1 = $RFG['beingRepliedScore1']*0.5;
			}else{
				$beingRepliedScore1 = $RFG['beingRepliedScore1'];
			}
			
			dbQuery("INSERT INTO zf_reply (fid, fellowid,parent_id, content, picurl, `datetime`, ip, authorid, isfirstpost,price) VALUES ($fid, $tid, $pid, '$content', '$picurl', '$datetime', '$ip', '$zid', 0, '$price')");
			dbQuery("UPDATE zf_contentpages SET commentnum = commentnum + 1, lastid=$zid,lastusername='{$username}', lastdatetime='$datetime' where id = '$tid'");
			
			if($isLog){
				dbQuery("UPDATE zf_user SET postnum = postnum + 1 , postnum_today=postnum_today+1, score1 = score1 + $score1AmountGet where `id` = $zid");
			}
			if($zid != $threadAuthorId && $threadAuthorId){
				dbQuery("UPDATE zf_user SET score1 = score1 + $beingRepliedScore1 where `id` = {$threadAuthorId}");
			}
			
			if($also_subscribe){
				dbQuery("INSERT IGNORE INTO zf_relation SET source_zid = {$zid}, target_zid = {$tid}, relation_type = 4");
			}
		}
		
	}