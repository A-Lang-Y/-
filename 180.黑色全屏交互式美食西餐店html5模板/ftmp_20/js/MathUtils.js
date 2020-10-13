function getRandomFromRange(min, max){
  return Math.random() * (max - min) + min;
}

function getRandomFromRangeInt(min, max){
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function DegToRad(deg) {
    return (Math.PI/180)*deg;
} 

function RadToDeg(rad) {
    return (180/Math.PI)*rad;
}

function getXOnCircle(radius_,angle_){
    return (radius_* Math.cos(DegToRad(angle_)));
}

function getYOnCircle(radius_,angle_){
    return (radius_* Math.sin(DegToRad(angle_)));
}
function windowH() {
	return (($(window).height()>=parseInt($('body').css('minHeight')))?$(window).height():parseInt($('body').css('minHeight')));
}
function windowW() {
	return (($(window).width()>=parseInt($('body').css('minWidth')))?$(window).width():parseInt($('body').css('minWidth')));
}
function windowHalfH() {
	return (windowH()*.5);
}
function windowHalfW() {
	return (windowW()*.5);
}