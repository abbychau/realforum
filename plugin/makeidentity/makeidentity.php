<h1><?php echo $htmltitle; ?></h1>


<div class='panel panel-default panel-body'>
<form name='IDForm'>
<p>台灣身份證 <input type="text" name="TaiwanID" size="40"></p>
<p>香港身份證 <input type="text" name="HongKongID" size="40"></p>
<p>中國身份證 <input type="text" name="ChinaID" size="40"></p>
<p>韓國身份證 <input type="text" name="KoreanID" size="40"></p>
<p>亞洲萬里通會員證 <input type="text" name="AsiaMilesID" size="40"></p>
</form>
</div>


<button class='btn btn-default' onclick="location.href=location.href">按此更換另一組</button>
<script>var gsALP="ABCDEFGHJKLMNPQRSTUVXYWZIO";function MakePID(c){var j=Math.round(Math.random()*(gsALP.length-1));var sNewPID=gsALP.substr(j,1);var i=gsALP.indexOf(sNewPID)+10;var iSumCheck=(i-i%10)/10+(i%10*9);if (c==3){c=Math.round(Math.random()*1)+1;}sNewPID += c;iSumCheck += c*8;var c;for (i=0;i<7;i++){c=Math.round(Math.random()*9);sNewPID += c;iSumCheck += c * (7-i);}sNewPID += ((10-iSumCheck%10)%10);return sNewPID;}document.IDForm.TaiwanID.value=MakePID(3);</script>

<script>function MakePID(c,date){var a1=Math.round(Math.random()*5+1);var a2=Math.round(Math.random()*4+1);var a3=Math.round(Math.random()*9);var a4=Math.round(Math.random()*9);var a5=Math.round(Math.random()*9);var a6=Math.round(Math.random()*9);var a7=date.substr(0,1);var a8=date.substr(1,1);var a9=date.substr(2,1);var aa=date.substr(3,1);var ab=date.substr(4,1);var ac=date.substr(5,1);var ad=date.substr(6,1);var ae=date.substr(7,1);var af=Math.round(Math.random()*9);var ag=Math.round(Math.random()*9);var m="13579";var f="02468";if(c==1){var ah=Math.round(Math.random()*(m.length-1));}else{if(c==2){var ah=Math.round(Math.random()*(f.length-1));}else{var ah=Math.round(Math.random()*9);}}switch((parseInt(a1)*7+parseInt(a2)*9+parseInt(a3)*10+parseInt(a4)*5+parseInt(a5)*8+parseInt(a6)*4+parseInt(a7)*2+parseInt(a8)*1+parseInt(a9)*6+parseInt(aa)*3+parseInt(ab)*7+parseInt(ac)*9+parseInt(ad)*10+parseInt(ae)*5+parseInt(af)*8+parseInt(ag)*4+parseInt(ah)*2)%11){case 0:var ai="1";break;case 1:var ai="0";break;case 2:var ai="X";break;case 3:var ai="9";break;case 4:var ai="8";break;case 5:var ai="7";break;case 6:var ai="6";break;case 7:var ai="5";break;case 8:var ai="4";break;case 9:var ai="3";break;case 10:var ai="2";break;}return a1.toString()+a2.toString()+a3.toString()+a4.toString()+a5.toString()+a6.toString()+a7.toString()+a8.toString()+a9.toString()+aa.toString()+ab.toString()+ac.toString()+ad.toString()+ae.toString()+af.toString()+ag.toString()+ah.toString()+ai.toString();}document.IDForm.ChinaID.value=MakePID(3,"19800101");</script>

<script>function MakePID(){var id=parseInt((Math.random()*26)+1);var sum=id*8;id=String.fromCharCode(id+64);for(i=1;i<=6;i++){s=Math.round(Math.random()*9);sum=sum+s*(8-i);id=id+s.toString();}id=id+(11-(sum%11)).toString();return id;}document.IDForm.HongKongID.value=MakePID();</script>

<script>function MakePID(c,date){var a1=parseInt(date.substr(0,1));var sum=a1*2;var id=a1.toString();var a2=parseInt(date.substr(1,1));sum=sum+a2*3;id=id+a2.toString();var a3=parseInt(date.substr(2,1));sum=sum+a3*4;id=id+a3.toString();var a4=parseInt(date.substr(3,1));sum=sum+a4*5;id=id+a4.toString();var a5=parseInt(date.substr(4,1));sum=sum+a5*6;id=id+a5.toString();var a6=parseInt(date.substr(5,1));sum=sum+a6*7;id=id+a6.toString();var a7=c;if(c==3){a7=Math.round(Math.random()*1+1);}sum=sum+a7*8;id=id+a7.toString();var a8=Math.round(Math.random()*9);sum=sum+a8*9;id=id+a8.toString();var a9=Math.round(Math.random()*9);sum=sum+a9*2;id=id+a9.toString();var aa=Math.round(Math.random()*9);sum=sum+aa*3;id=id+aa.toString();var ab=Math.round(Math.random()*9);sum=sum+ab*4;id=id+ab.toString();var ac=Math.round(Math.random()*9);sum=sum+ac*5;id=id+ac.toString();id=id+((11-(sum%11))%10).toString();return id;}document.IDForm.KoreanID.value=MakePID(3,"800101");</script>

<script>function MakePID(){
    var a1=1;var a2=Math.round(Math.random()*9);
    var a3=Math.round(Math.random()*9);
    var a4=Math.round(Math.random()*9);
    var a5=Math.round(Math.random()*9);
    var a6=Math.round(Math.random()*9);
    var a7=Math.round(Math.random()*9);
    var a8=Math.round(Math.random()*9);
    var a9=Math.round(Math.random()*9);
    var cd=(a1*1+a2*2+a3*3+a4*4+a5*5+a6*6+a7*7+a8*8+a9*9)%10;
    return ""+a1+a2+a3+a4+a5+a6+a7+a8+a9+cd;
}document.IDForm.AsiaMilesID.value=MakePID();</script>