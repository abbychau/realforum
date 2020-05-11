function InsertYoutube(str) {
	AddTag("[youtube]" + str, "[/youtube]");
}


function AddTag(openTag, closeTag) {
    var textArea = $('#content');
    var len = textArea.val().length;
    var start = textArea[0].selectionStart;
    var end = textArea[0].selectionEnd;
    var selectedText = textArea.val().substring(start, end);
    var replacement = openTag + selectedText + closeTag;
    textArea.val(textArea.val().substring(0, start) + replacement + textArea.val().substring(end, len));
}
function wrapTag(tag){
AddTag("["+tag+"]", "[/"+tag+"]");
}

document.write("<style type='text/css'>.colorpicker201{visibility:hidden;display:none;position:absolute;background:#FFF;z-index:999;}</style>");


function setCCbldSty2(objID, prop, val) {
	switch (prop) {
	case "bc":
		if (objID != 'none') {
			document.getElementById(objID).style.backgroundColor = val;
		};
		break;
	case "vs":
		document.getElementById(objID).style.visibility = val;
		break;
	case "ds":
		document.getElementById(objID).style.display = val;
		break;
	case "tp":
		document.getElementById(objID).style.top = val;
		break;
	case "lf":
		document.getElementById(objID).style.left = val;
		break;
	}
}

function putOBJxColor2(Samp, pigMent, textBoxId) {
	if (pigMent != 'x') {
		AddTag('[color=#' + pigMent + ']', '[/color]');
		setCCbldSty2(Samp, 'bc', pigMent);
	}
	setCCbldSty2('colorpicker201', 'vs', 'hidden');
	setCCbldSty2('colorpicker201', 'ds', 'none');
}

function showColorGrid2(Sam, textBoxId) {
	var objX = new Array('00', '33', '66', '99', 'CC', 'FF');
	var c = 0;
	var xl = '"none","x", ""';
	var mid = '';

	mid += '<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="border:solid 0px #F0F0F0;padding:2px;"><tr>';
	mid += "<td colspan='17' align='left' style='margin:0;padding:2px;height:12px;' ><input type='text' size='12' id='o5582n66' value='#FFFFFF'><input type='text' size='2' style='width:14px;' id='o5582n66a' onclick='javascript:alert(\"click on selected swatch below...\");' value='' style='border:solid 1px #666;'></td><td colspan='1' align='right' onclick='javascript:putOBJxColor2(" + xl + ")'><span style='border:1px solid #CCC; padding:1px 3px;cursor:pointer'>X</span></td></tr><tr>";
	var br = 1;
	for (o = 0; o < 6; o++) {
		mid += '</tr><tr>';
		for (y = 0; y < 6; y++) {
			if (y == 3) {
				mid += '</tr><tr>';
			}
			for (x = 0; x < 6; x++) {
				var grid = '';
				grid = objX[o] + objX[y] + objX[x];
				var b = "'none','" + grid + "', ''";
				mid += '<td style="background-color:#' + grid + '" onclick="javascript:onclick=putOBJxColor2(' + b + ');" onmouseover=javascript:document.getElementById("o5582n66").value="#' + grid + '";javascript:document.getElementById("o5582n66a").style.backgroundColor="#' + grid + '"; width="12" height="12"></td>';
				c++;
			}
		}
	}
	mid += "</tr></table>";
	document.getElementById('colorpicker201').innerHTML = mid;
	setCCbldSty2('colorpicker201', 'vs', 'visible');
	setCCbldSty2('colorpicker201', 'ds', 'inline');
}

function showSmileyGrid(Sam, textBoxId) {
	$('#smileypicker').toggle();
}

function smileLine(file) {
	return ("<img src=\"\/images\/smileys\/" + file + ".gif\" onclick=\"AddTag('[emot]" + file + "[/emot]','')\" alt='" + file + "' \/>");
}

function createSmiley(dom) {

	var str = '';

var emot=[

['peanuts1','peanuts2','peanuts3','369','Adore','Agree1','Angel','Angry','Ass','at_at','Banghead','Biggrin','Bomb','Bouncer','Bouncy','Bye','Censored','Chicken','Clown','Cry1','Dead','Devil','Donno','Fire1','Flowerface','Frown','Fuck','Good','Hehe','Hoho','Kill','Kill2','Kiss','Love','No','Offtopic','Oh','Photo','Shocking','Slick','Smile','Sosad','Surprise','Tongue','Wink','Wonder','Wonder2','Yipes','Z'],

['90553490','90553493','90553496','90553498','90553501','90553503','90553505','90553508','90553510','90553512','90553515','90553519','90553522','90553525','90553527','90553529','90553531','90553535','90553537','91150448','91150449','91150452','91150456','91150458','91150460','91150464','91150468','91150469','91150471','93422746','93422747','93422749','93422750','93422753','93422754','93422755','93422756','93422757','93422758','93422760'],

['smile','frown','bigsmile','angry','evil','sneaky','saint','surprise','confuse','worry','neutral','irritated','tongue','bigeyes','cool','wink','bigwink','anime','sweatdrop','lookright','lookleft','laugh','smile3','wink3','teeth','boggle','blue','sleepy','heart','star'],

['s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47'],

['7_0','7_1','7_2','7_3','7_4','7_5','7_6','7_7','7_8','7_9','7_10','7_11','7_12','7_13','7_14','7_15','7_16','7_17','7_18','7_19','7_20'],

['m0','m1','m2','m3','m4','m5','m6','m7','m8','m9','m10','m11','m12','m13','m14','m15','m16','m17','m18','m19','m20','m21','m22','m23','m24','m25','m26','m27','m28','m29','m30','m31','m32','m33','m34','m35']

];
	var length = emot.length, element = null;
	for (var i = 0; i < emot.length; i++) {
		for(var j=0;j < emot[i].length;j++){
			str += smileLine(emot[i][j]);
		}
		str += "<hr />";
	}
	

	$('#' + dom).html(str);
}