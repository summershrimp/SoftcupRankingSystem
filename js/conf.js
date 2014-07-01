function conf(url, request) {
	var wall=document.createElement("div");
	wall.id="wall";
	document.body.appendChild(wall);
	dom=document.getElementById("wall");
	dom.innerHTML=
	'<div id="conf">'+
		'<span>'+request+'</span>'+
		'<p>'+
		'<input class="button" type="button" value="是" onclick="window.location.href=\''+url+'\'" />'+
		'<input class="button" type="button" value="否" onclick="cancel()"/>'+
		'</p>'+
	'</div>';
}
function cancel() {
	var dom = document.getElementById("wall");
	dom.parentNode.removeChild(dom);
}