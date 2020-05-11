<script type="text/javascript"> 
function delnull()
{
var str=document.getElementById('text').value;
str=str.replace(/([\s]*\r\n[\s]*){2,}/gm,"\r\n");
document.getElementById('text').value=str;
}
function refix()
{
var str=document.getElementById('text').value;
str=str.replace(/([\s]*\r\n[\s]*){2,}/gm,"\r\n\r\n");
document.getElementById('text').value=str;
}
function url()
{
var str=document.getElementById('text').value;
str=str.replace(/^[ ]*(http:\/\/|^mms:\/\/|rtsp:\/\/|pnm:\/\/|ftp:\/\/|mmst:\/\/|mmsu:\/\/)([^\r\n]*)$/igm,"[url]$1$2[/url]");
document.getElementById('text').value=str;
}

function addbr()
{
var str=document.getElementById('text').value;
str=str.replace(/\r\n/gm,"\r\n\r\n");
document.getElementById('text').value=str;
}

function html_trans(str) {
str = str.replace(/\r/g,"");
str = str.replace(/on(load|click|dbclick|mouseover|mousedown|mouseup)="[^"]+"/ig,"");
str = str.replace(/<script[^>]*?>([\w\W]*?)<\/script>/ig,"");
if(set.fontbash.checked)
{
str = str.replace(/<span[^>]*?display\s*?:\s*?none[^>]*?>([\w\W]*?)<\/span>/ig,"");
str = str.replace(/<span[^>]*?font\s*?-\s*?size\s*?:\s*(0px|0pt)[^>]*?>([\w\W]*?)<\/span>/ig,"");
str = str.replace(/<font([^>]+)(0px|0pt)+([^>]*)>([\w\W]*?)<\/font>/ig,"");
}

if(set.filtrate.checked)
{
str = str.replace(/[^<]*<([^>]*?)>[^<]*/ig,"<$1>");
tm=window.textfield.value;
if(tm.length<1){
var arr;
arr=str.match(/<img[^>]+src=[" ]?([^"]+)[" ]?[^>]*>/ig);
tm=arr[0].replace(/<img[^>]+src=[" ]?([^"]+)[" ]?[^>]*>/ig,"$1")+"\"";
i=tm.search(/\/[^\/]+"/ig);
tm=tm.substr(0,i);
window.textfield.value=tm+"/";
}
if(tm.substr(tm.length-1,1)!="/") tm+="/";
var strtm="<img[^>]+src=[\"]?("+tm+"[^\"]+)[\"]?[^>]*>";
var re = new RegExp(strtm,"ig");
str = str.replace(re,"\n[img]$1[/img]\n");
}
else
{
if(set.stext.checked) str = str.replace(/[^<]*<([^>]*?)>[^<]*/ig,"<$1>");

if(!set.linka.checked) str = str.replace(/<a[^>]+href=[" ]?([^"]+)[" ]?[^>]*>(.*?)<\/a>/ig,"[url=$1]$2[/url]");
if(!set.font_color.checked&&!set.stext.checked)
str = str.replace(/<font([^>]+)color=([^ >]+)([^>]*)>(.*?)<\/font>/ig,"[color=$2]<font$1$3>$4</font>[/color]");
if(!set.font_size.checked&&!set.stext.checked)
str = str.replace(/<font([^>]+)size=([^ >]+)([^>]*)>(.*?)<\/font>/ig,"[size=$2]<font$1$3>$4</font>[/size]");
if(!set.font_face.checked&&!set.stext.checked)
str = str.replace(/<font[^>]+face=([^ >]+)[^>]*>(.*?)<\/font>/ig,"[font=$1]$2[/font]");
if(!set.img.checked) str = str.replace(/<img[^>]+src=[" ]?([^"]+)[" ]?[^>]*>/ig,"\n[img]$1[/img]\n");

if(!set.odj.checked){
//return str;
str = str.replace(/<object[^>]*?6BF52A52\-394A\-11d3\-B153\-00C04F79FAA6[^>]*?>.*<param[^>]+name\s*=\s*["](url|src)["][^>]+value=[" ]?([^"]+)[" ][^>]*>.*<\/object>/ig,"\n[wmv]$2[/wmv]\n"); 
str = str.replace(/<object[^>]*?D27CDB6E\-AE6D\-11cf\-96B8\-444553540000[^>]*?>.*<param[^>]+name\s*=\s*["](url|src)["][^>]+value=[" ]?([^"]+)[" ][^>]*>.*<\/object>/ig,"\n[swf]$2[/swf]\n");
str = str.replace(/<embed[^>]*type=["]?application\/x\-shockwave\-flash["]?[^>]*src=[" ]?([^"|^ ]+)[" ]?[^>]*>/ig,"\n[swf]$1[/swf]\n");
str = str.replace(/<embed[^>]*src=["]?([^"|^ ]+)["]?[^>]*type=["]?application\/x\-shockwave\-flash["]?[^>]*>/ig,"\n[swf]$1[/swf]\n");
str = str.replace(/<object[^>]*?CFCDAA03\-8BE4\-11cf\-B84B\-0020AFBBCCFA[^>]*?>.*<param[^>]+name\s*=\s*["](url|src)["][^>]+value=[" ]?([^"]+)[" ][^>]*>.*<\/object>/ig,"\n[rm]$2[/rm]\n"); 
}
if(!set.font_b.checked&&!set.stext.checked){
str = str.replace(/<([\/]?)b>/ig,"[$1b]");
str = str.replace(/<([\/]?)strong>/ig,"[$1b]");}
if(!set.font_u.checked&&!set.stext.checked)
str = str.replace(/<([\/]?)u>/ig,"[$1u]");
if(!set.font_i.checked&&!set.stext.checked)
str = str.replace(/<([\/]?)i>/ig,"[$1i]");

str = str.replace(/&nbsp;/g," ");
str = str.replace(/&amp;/g,"&");
str = str.replace(/&quot;/g,"\"");
str = str.replace(/&lt;/g,"<");
str = str.replace(/&gt;/g,">");
}
str = str.replace(/<br>/ig,"\n");
str = str.replace(/<p[^>]*?>/ig,"\n\n");
str = str.replace(/<[^>]*?>/g,"");
str = str.replace(/\[url=([^\]]+)\]\n(\[img\]\1\[\/img\])\n\[\/url\]/g,"$2");
str = str.replace(/\n+/g,"\n");

return str;
}
function copycode(obj){
obj.select();
objcopy=obj.createTextRange();
objcopy.execCommand("Copy");
}
function trans(){
var str = "";
rtf.focus();
rtf.document.body.innerHTML = "";
rtf.document.execCommand("paste");
str = rtf.document.body.innerHTML;
if(str.length == 0) {
alert("剪貼版不存在超文本數據！");
return "";
}
return html_trans(str);
}
function preview(){
var prewin=window.open("","","");
prewin.document.write(rtf.document.body.innerHTML);
}
function zhen(str)
{
strfound=str.replace(/\\/ig,"\\\\");
strfound=strfound.replace(/\[/ig,"\\[");
strfound=strfound.replace(/\]/ig,"\\]");
strfound=strfound.replace(/\{/ig,"\\{");
strfound=strfound.replace(/\}/ig,"\\}");
strfound=strfound.replace(/\|/ig,"\\|");
strfound=strfound.replace(/\//ig,"\\/");
strfound=strfound.replace(/\^/ig,"\\^");
strfound=strfound.replace(/\./ig,"\\.");
strfound=strfound.replace(/\*/ig,"\\*");
strfound=strfound.replace(/\?/ig,"\\?");
strfound=strfound.replace(/\+/ig,"\\+");
return strfound;
}
function replace_star()
{
var str=document.getElementById('text').value;
if(!reg.checked)
strfound=zhen(find_text.value);
else
strfound=find_text.value;
var re = new RegExp(strfound,"ig");
str=str.replace(re,replace_text.value);
document.getElementById('text').value=str;
}
</script>
<h4>論壇轉貼工具</h4>
<table border=0 cellSpacing=1 cellPadding=10 width=650 bgColor="#cccccc" align="center">

  <tr>
    <td bgColor="#f6f6f6" align=middle>
    <textarea onbeforepaste="if(document.getElementById('x_paste').checked){window.clipboardData.setData('text',trans());this.focus();}" style="width:100%; height: 200px" id=text class=textarea rows=1 cols=100 name=textarea></textarea> 
      <iframe style="width: 0px; height: 0px" id=rtf marginHeight=0 
      src="" marginWidth=0 scrolling=no></iframe>
      <label for=x_paste></label>
      <table border="0" cellSpacing="1" borderColor="#f6f6f6" width="100%" align="center">
        <tbody>
        <tr vAlign=center align=middle>
          <td height=44 width=80><input style="width: 80px; height: 40px" onClick="document.getElementById('text').value += trans();" value=轉換(追加) type=button name=button> 
          </td>
          <td width=80><input style="width: 80px; height: 40px" onClick="document.getElementById('text').value = trans()" value=轉換(覆蓋) type=button name=button> 
          </td>
          <td width=85>
          <input style="width: 95px; height: 40px" onclick=copycode(window.text) value="復制到剪貼板" type=button> 
          </td>
          <td width=85>
            <table border=0 cellSpacing=2 cellPadding=0 width=0>
              <tbody>
              <tr>
                <td><input style="width: 85px; height: 20px" onclick=preview() value="預覽帖子 " type=button name=preview></td>
              </tr>
              <tr>
                <td><input style="width: 85px; height: 20px" onClick="document.getElementById('text').value=''" value=清空內容 type=button></td></tr>
                </tbody>
             </table>     
          </td>
          <td width=170>
            <table border=0 cellSpacing=2 cellPadding=0 width="100%">
              <tbody>
              <tr>
                <td><input style="width: 80px" title="自動分析所有超鏈接，並轉換成超鏈接格式&#13;&#10;注意：超鏈接必須單獨在一行中！" onclick=url() value="分析超鏈接" type=button name=Submit>
                </td>
                <td><input style="width: 80px" title=緊湊格式，刪除所有空行 onclick=delnull() value=清除空行 type=button name=Submit></td>
              </tr>
              <tr>
                <td><input style="width: 80px" title=清除多余的空行，保持最一個空行 onclick=refix() value=清除多余 type=button name=Submit></td>
                <td><input style="width: 80px" title=為每一行（包括空行）增加一空行 onclick=addbr() value=增加空行 type=button name=Submit></td>
              </tr>
            </tbody>
          </table>
        </td>
        </tr>
        </tbody>
      </table>
      
      <form name="set">
      <table border=0 cellSpacing=5 cellPadding=0 width="100%">
        <tbody align="left">

        <tr>
          <td title="轉換的結果中將不含有圖片信息" height=20 width=100><label 
            for=img><input id=img type="checkbox">屏蔽圖片</label></td>
          <td title="轉換的結果中將不含有鏈接信息" width=100><label for=linka><input 
            id=linka type="checkbox">屏蔽超鏈接</label></td>
          <td title="轉換的結果中將不含音頻、視頻、FLASH等信息" width=100><label 
            for=odj><input id=odj type="checkbox">屏蔽對像</label></td>
          <td title="轉換的結果中將不含文本信息，同時字體屬性將被自動屏蔽" width=100><label 
            for=stext><input id=stext type="checkbox">屏蔽文字</label></td>
          <td title="為了方便帖子的閱讀，強制把圖片用空行隔開" width=100><label 
            for=filtrate><input id=filtrate 
            onclick="if(this.checked)window.base_url.style.display='block';else window.base_url.style.display='none';" 
            type="checkbox">啟用圖片過濾</label></td>
        </tr>
        <tr>
          <td title="屏蔽所有定字體相關的屬性"><label for=font><input id=font 
            onclick=font_color.checked=this.checked;font_size.checked=this.checked;font_face.checked=this.checked;font_b.checked=this.checked;font_i.checked=this.checked;font_u.checked=this.checked; 
            type="checkbox">屏蔽字體屬性</label></td>
          <td title="屏蔽所有定字體相關的屬性"><label><input id=fontbash 
            value=checkbox CHECKED type="checkbox">屏蔽干擾碼</label></td>
          <td title=轉換的結果中將不含有字體顏色信息><label for=font_color><input 
            id=font_color type="checkbox">屏蔽字顏色</label></td>
          <td title=轉換的結果中將不含有字體尺寸信息><label for=font_size><input 
            id=font_size type="checkbox">屏蔽字體尺寸</label></td>
          <td title=轉換的結果中將不含有字體類型信息><label for=font_face><input 
            id=font_face type="checkbox">屏蔽字體類型</label></td>
        </tr>
        <tr>
          <td title=轉換的結果中將不含有粗體信息><label for=font_b><input id=font_b 
            type="checkbox">屏蔽粗體</label></td>
          <td title=轉換的結果中將不含有斜體信息><label for=font_i><input id=font_i 
            type="checkbox">屏蔽斜體</label></td>
          <td title=轉換的結果中將不含有下劃線信息><label for=font_u><input id=font_u 
            type="checkbox">屏蔽下劃線</label></td>
         </tr>
         </tbody>
      </table></form>
      
      <table border=0 cellSpacing=2 borderColor="#efefef" cellPadding=2 width="100%" bgColor=#f6f6f6>
        <tbody>
        <tr>
          <td width=320>查找 <input 
            id=find_text size=36 name=find_text></td>
          <td width=60><input onClick="set.reset();find_text.value='';replace_text.value='';window.textfield.value='';" value=恢復默認 type=button name=submit></td>
          <td rowSpan=2 width=140 align=middle><label for=reg><input 
            id=reg value=1 CHECKED type="checkbox" 
        name=reg>使用正則語法</label></td></tr>
        <tr>
          <td>替換 <input id=replace_text 
            size=36 name=replace_text></td>
          <td><input onclick=replace_star() value=開始替換 type=button name=submit></td></tr></tbody></table></td>
        </tr>
        <tr bgColor="#f8f8f8">
          <td align="center">
                  <P><B>轉貼工具使用說明：</B><br />1.在網頁中拖動鼠標選中你想要的圖片或文字，然後鼠標右鍵“復制(C)”或按Ctrl+C。<br />2.進入該頁面，直接按下“轉換（追加）”或者“轉換（覆蓋）”。<br />3.點擊“復制到剪貼板”,將代碼復制到剪貼板。<br />4.進入論壇發貼頁面，鼠標右鍵“粘貼(P)”或按Ctrl+V將帖子內容復制到帖子內容框。 
                  </P>
          </td>
        </tr>
        </tbody>
      </table>
    </td>
  </tr>
  
</table> 

<script type="text/javascript">
rtf.document.designMode="On";
</script>
<br />
<br />


<h4>繁簡文字轉換系統</h4>
<table width="650" align="center" bgcolor="#FFFFFF">
  <tbody>
  <tr>
    <td>
    
      <div style="Z-INDEX: 100" id=popmenu class=menuskin 
      onmouseover="clearhidemenu();highlightmenu(event,'on')" 
      onmouseout="highlightmenu(event,'off');dynamichide(event)"></div>
      <table style="border:1px solid #999; width:100%" align="center">
        <tr>
          <td align="center">
			<font color="blue">使用方法 : 
            在「Ａ框」輸入繁或簡體文字，然後點選要轉之格式，Ｂ框便會顯示您所需要的。<br />　</font> 
            <table id="table1" border=0 width="100%"><tr>
                <td align=middle>
                <form onSubmit="return false" name=myForm>
                <font size=4><B>Ａ框</B></font><br />
                <textarea style="font-SIZE: 10pt" rows=10 cols=70 name=S1></textarea><br /><br />
                轉換為：
                <input onclick=BIGtoGB=0;toCode() value="簡體 Unicode" type=button name=B1>
                <input onclick=BIGtoGB=1;toCode() value="繁體 Unicode" type=button name=B2>
                <input onclick=BIGtoGB=2;toCode() value="簡體 GB" type=button name=B3><input onclick=BIGtoGB=3;toCode() value="繁體 BIG-5" type=button name="B4">
                <input value=ON type="checkbox" name=C1>HTML<br /><br />
                <font size=4><B>Ｂ框</B></font><br />
                <textarea style="font-SIZE: 10pt" rows=10 cols=70 name=S2></textarea>
                </form></td></tr></table>
            </td>
        </tr>
      </table>

    </td>
  </tr>
  </tbody>
</table>
<div style="DISPLAY: none" id=p1></div>
<script type="text/javascript" src="/plugin/transbbcode/dependents/GB2312TOBIG5.js"></SCRIPT>
<script type="text/javascript" src="/plugin/transbbcode/dependents/GBCodeUnicode.js"></SCRIPT>
<script type="text/javascript" src="/plugin/transbbcode/dependents/GB2312TOBIGGB.js"></SCRIPT>
<script type="text/javascript" src="/plugin/transbbcode/dependents/BIG5TOGB2312.js"></SCRIPT>
<script type="text/javascript" src="/plugin/transbbcode/dependents/BIGCodeUnicode.js"></SCRIPT>
<script type="text/javascript" src="/plugin/transbbcode/dependents/BIG5TOGBBIG.js"></SCRIPT>
<script type="text/javascript"><!--
//V0.2
var BIGtoGB = 0;

function toCode(){
	var TempStr = "";
	var TempStr1 = "";
	var TempStrWord = "";
	var TempWordMath = 0;
	var TempWordHex = new Array();
	if(document.myForm.C1.checked){
		document.getElementById("p1").innerHTML = document.myForm.S1.value;
		TempStrWord = document.getElementById("p1").innerText;
	}else{
		TempStrWord = document.myForm.S1.value;
	}
	for(i=0;i<TempStrWord.length;i++){
		TempStr1 = TempStrWord.charAt(i);
		TempWordMath = TempStr1.charCodeAt(0);
		switch(BIGtoGB){
		case 0:
			if(!toGB[TempWordMath]){
				TempStr += TempStr1;
			}else{
				TempStr += String.fromCharCode(toGB[TempWordMath]);
			}
			break;
		case 1:
			if(!toBIG[TempWordMath]){
				TempStr += TempStr1;
			}else{
				TempStr += String.fromCharCode(toBIG[TempWordMath]);
			}
			break;
		case 2:
			if(!toGB2[TempWordMath]){
				TempStr += TempStr1;
			}else{
				TempStr += toGB2[TempWordMath];
			}
			break;
		case 3:
			if(!toBIG2[TempWordMath]){
				TempStr += TempStr1;
			}else{
				TempStr += toBIG2[TempWordMath];
			}
			break;
		}
	}
	document.myForm.S2.value = TempStr;
}
//--></SCRIPT>
