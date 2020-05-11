<div class="modal fade"  id='footersettings' tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">設置</h4>
			</div>
			<div class="modal-body">
				<table class='table'>
					<tr>
						<td>發聲提示:</td>
						<td>
							<a onclick="createCookie('mute','true',300);window.location.reload();">靜音</a>
							<a onclick="createCookie('mute','false',300);window.location.reload();">打開</a>
						</td>
					</tr>
					<tr>
						<td>背景色:</td>
						<td><input style="width:100px" type='text' value='<?=$_COOKIE['bgcolor'];?>' id='bgcolor' />
							<button type="button" onclick="createCookie('bgcolor',$('#bgcolor').val(),300);window.location.reload();">Set</button>
							<button type="button" onclick="createCookie('bgcolor','',300);window.location.reload();">Clear</button>
							<a href='http://widgets.zkiz.com/static/rgb.php' target="_blank">參考</a>
						</td>
					</tr>
					<tr>
						<td>主題/回覆字體大小:</td>
						<td><input style="width:100px" type='text' value='<?=$_COOKIE['reply_fontsize'];?>' id='reply_fontsize' />px
							<button type="button" onclick="createCookie('reply_fontsize',$('#reply_fontsize').val(),300);window.location.reload();">Set</button>
							<button type="button" onclick="createCookie('reply_fontsize','',300);window.location.reload();">Clear</button>
						</td>
					</tr>
					<tr>
						<td>字體設定:</td>
						<td>
							<input style="width:100px" type='text' value='<?=$_COOKIE['allfont'];?>' id='allfont' />
							<button type="button" onclick="createCookie('allfont',$('#allfont').val(),300);window.location.reload();">Set</button>
							<button type="button" onclick="createCookie('allfont','',300);window.location.reload();">Clear</button>
						</td>
					</tr>
					<tr>
						<td>內文禁用新細明體:</td>
						<td>
							<a onclick="createCookie('txt_heioff','0',300);window.location.reload();">關閉</a> 
							<a onclick="createCookie('txt_heioff','1',300);window.location.reload();">打開</a>
						</td>
					</tr>
					<tr>
						<td>快速發貼自動顯示其他選項:</td>
						<td>
							<a onclick="createCookie('show_qpsubs','0',300);window.location.reload();">關閉</a> 
							<a onclick="createCookie('show_qpsubs','1',300);window.location.reload();">打開</a>
						</td>
					</tr>
					<tr>
						<td>摘錄功能:</td>
						<td>
							<a onclick="createCookie('disable_goldshare','1',300);window.location.reload();">關閉摘錄功能</a> 
							<a onclick="createCookie('disable_goldshare','0',300);window.location.reload();">打開摘錄功能</a>
						</td>
					</tr>
				</table>
				<hr />
				Settings:<br />
				bgcolor&gt;<?=$_COOKIE['bgcolor'];?> <br />
				mute&gt;<?=$_COOKIE['mute'];?> <br />
				show_qpsubs&gt;<?=$_COOKIE['show_qpsubs'];?> <br />
				disable_goldshare&gt;<?=$_COOKIE['disable_goldshare'];?>
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div id="modelDialog" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body"></div>
			<!--
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				
			-->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<audio id='noti_mp3' src="/newnoti.mp3" class='hide2'></audio>






<div style='z-index:100;font-weight:100; bottom:25px;right:100px; display:none;border:1px solid #CCC;background:white' id="chatroom_load" class='rf_fixed'>
	<iframe id="chatroom_iframe" style="background:white;border:0;width:620px;height:200px"></iframe>	
</div>


<div id='toTop' style="padding: 5px 3px;bottom: 5px;right: 5px;display: none;cursor:pointer" onclick="$('html, body').animate({scrollTop:0}, 'fast');"  class='rf_fixed'>
		<div style="display:block; padding:.6em .9em; background:#AAA;border-radius:1em;color:white">
<span class="glyphicon glyphicon-arrow-up"></span>
</div>
</div>



<div id='iframe_box' class='rightbar navFellow ' style='margin-top:32px; padding:5px; border:0; background:#DDD;border-radius:5px'>
	<iframe id='iframe_boxi' class='resizable' style='width:990px;height:700px;border:0; background:white'></iframe>
	<div>
		<input class="text" id='iframe_box_url' style='width:750px;border:1px #ddd; background:white'/>
		<button type="button" class="button withnext notext"  onclick='$("#iframe_boxi").attr("src",$("#iframe_box_url").val());'></button> 
		<button type="button" class="button arrowCircleDown notext"  onclick='$("#iframe_boxi").height($("#iframe_boxi").height()+100);'></button> 
		<button type="button" class="button arrowCircleUp notext"  onclick='$("#iframe_boxi").height($("#iframe_boxi").height()-100);'></button> 
		<button type="button" class="button deletebtn"  onclick='$("#iframe_box").hide("fast")'></button> 
	</div>
</div>



<div id="desktopTest" class="visible-sm visible-md visible-lg"></div>