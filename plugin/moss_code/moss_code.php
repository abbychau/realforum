<h4>摩斯密碼轉換器</h4>

<script type="text/javascript">
	// <![CDATA[
morsecode=new Array;
morsekey=0
morsecode[morsekey++]=["A",".-"]
morsecode[morsekey++]=["B","-..."]
morsecode[morsekey++]=["C","-.-."]
morsecode[morsekey++]=["D","-.."]
morsecode[morsekey++]=["E","."]
morsecode[morsekey++]=["F","..-."]
morsecode[morsekey++]=["G","--."]
morsecode[morsekey++]=["H","...."]
morsecode[morsekey++]=["I",".."]
morsecode[morsekey++]=["J",".---"]
morsecode[morsekey++]=["K","-.-"]
morsecode[morsekey++]=["L",".-.."]
morsecode[morsekey++]=["M","--"]
morsecode[morsekey++]=["N","-."]
morsecode[morsekey++]=["O","---"]
morsecode[morsekey++]=["P",".--."]
morsecode[morsekey++]=["Q","--.-"]
morsecode[morsekey++]=["R",".-."]
morsecode[morsekey++]=["S","..."]
morsecode[morsekey++]=["T","-"]
morsecode[morsekey++]=["U","..-"]
morsecode[morsekey++]=["V","...-"]
morsecode[morsekey++]=["W",".--"]
morsecode[morsekey++]=["X","-..-"]
morsecode[morsekey++]=["Y","-.--"]
morsecode[morsekey++]=["Z","--.."]
morsecode[morsekey++]=["1",".----"]
morsecode[morsekey++]=["2","..---"]
morsecode[morsekey++]=["3","...--"]
morsecode[morsekey++]=["4","....-"]
morsecode[morsekey++]=["5","....."]
morsecode[morsekey++]=["6","-...."]
morsecode[morsekey++]=["7","--..."]
morsecode[morsekey++]=["8","---.."]
morsecode[morsekey++]=["9","----."]
morsecode[morsekey++]=["0","-----"]
morsecode[morsekey++]=["?","..--.."]
morsecode[morsekey++]=["/","-..-."]
morsecode[morsekey++]=["[","-.-.."]
morsecode[morsekey++]=["]",".---."]
morsecode[morsekey++]=["-","-....-"]
morsecode[morsekey++]=[".",".-.-.-"]
morsecode[morsekey++]=["@","--.-."]
morsecode[morsekey++]=["*","----"]
morsecode[morsekey++]=["$","...-."]
morsecode[morsekey++]=["#","..--"]

function morse2word(morse){
	if (morse.Right(1)==" ") morse=morse.Left(morse.length-1);
	var morsearr= morse.split(" ");
	var wordarr=new Array;
	var key=0;
	for (var i=0;i<morsearr.length;i++){
		for (var j=0;j<morsecode.length;j++){
			if (morsearr[i]==morsecode[j][1]){
				wordarr[i]=morsecode[j][0];
				key++;
			}
		}
	}
	if (key!=morsearr.length) return "對不起,請在兩個連續莫斯密碼中間加上空格."
	var word=""
	for (var i=0;i<wordarr.length;i++){
		word+=wordarr[i]+"";
	}
	return word;
}

function word2morse(word){
	var wordarr=new Array;
	var morsearr=new Array;
	var spacelen= word.split(" ");
	if (spacelen.length>1) return "對不起,請不要在英文字母中間加上空格.你可以試用減號來代表中間的間隔."
	var oldlen=word.length;
	for (var i=0;i<oldlen;i++){
		wordarr[i]=word.Left(1).toUpperCase();
		word=word.Right(word.length-1);
	}
	for (var i=0;i<wordarr.length;i++){
		for (var j=0;j<morsecode.length;j++){
			if (wordarr[i]==morsecode[j][0]){
				morsearr[i]=morsecode[j][1];
			}
		}
	}
	var morse=""
	for (var i=0;i<morsearr.length;i++){
		morse+=morsearr[i]+" ";
	}
	return morse;
}

String.prototype.Left = function(len){
	if(isNaN(len)||len==null){
		len = this.length;
	}else{
		if(parseInt(len)<0||parseInt(len)>this.length){
			len = this.length;
		}
	}	
	return this.substr(0,len);
}

String.prototype.Right = function(len){
	if(isNaN(len)||len==null){
		len = this.length;
	}else{
		if(parseInt(len)<0||parseInt(len)>this.length){
			len = this.length;
		}
	}	
	return this.substring(this.length-len,this.length);
}
	// ]]>
</script>
<p>莫爾斯/摩爾斯電碼(Morse code)是美國人莫爾斯於1844年發明的，由點（.）、劃（-）兩種符號組成： </p>
<ol>
  <li> 一點為一基本信號單位，一劃的長度=3點的長度。 </li>
  <li>在一個字母或數字內，各點、劃之間的間隔應為兩點的長度。 </li>
  <li>字母（數字）與字母（數字）之間的間隔為7點的長度。</li>

</ol>
<br />
<p>莫爾斯/摩爾斯電碼(Morse code)曾被用在間諜通信，電報，航海信號等各個領域。</p>
<br />
<form id="morsecode" method="post" action="" class="center" onsubmit="return false;">
  <p>
    <label>
    <textarea name="word" id="word" cols="45" rows="5"></textarea>

    </label>
  </p>
  <p style="margin-bottom:0.5em;">
    <label>
    <button onclick="document.getElementById('morse').value=word2morse(document.getElementById('word').value) ;">↓word2morse</button>
    </label>
    <label>
    <button onclick="document.getElementById('word').value=morse2word(document.getElementById('morse').value) ;">↑morse2word</button>

    </label>
  </p>
  <p>
    <label>
    <textarea name="morse" id="morse" cols="45" rows="5">- . ... - </textarea>
    </label>
  </p>
</form>