var objectSlid = Object.create(Slider);
objectSlid.init();
//setInterval(function(){objectSlid.chgImg(1)}, 5000);
document.getElementById("prev").onclick = function() {objectSlid.chgImg(-1)};
document.getElementById("next").onclick = function() {objectSlid.chgImg(1)};
document.onkeydown = function(){objectSlid.keyImg(event)};