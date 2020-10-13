/* 
Robert Penner's original easing equations modified for JQuery animate method, Jamie Lemon 2009 lemonsanver.com

Below are easing equations based on Robert Penner's work, modified for JQuery
The "In" part of an animation is the start of it, the "Out" part is the end of it
If you apply "easing" at the "In" or the "Out" then the supplied animation curve is most apparent at that point
Enjoy the animation curves!

usage: $(".myImageID").animate({"left": "+=100"},{queue:false, duration:500, easing:"bounceEaseOut"});

function list:
back 
bounce
circ
cubic
elastic
expo
quad
quart
quint
sine


Note in JQuey's native animate function the supplied parameters are supplied as follows:

easingAlgorythmEaseType: function( p, n, firstNum, diff )

@param p The time phase between 0 and 1
@param n Not sure what this is :), in any case its not used
@param firstNum The first number in the transform
@param diff The difference in in pixels required

*/

/*
Disclaimer for Robert Penner's Easing Equations license:

TERMS OF USE - EASING EQUATIONS

Open source under the BSD License.

Copyright Â© 2001 Robert Penner
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
    * Neither the name of the author nor the names of contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

jQuery.extend({
    
    easing: 
    {

        // ******* back
        backEaseIn:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            var s = 1.70158; // default overshoot value, can be adjusted to suit
            return c*(p/=1)*p*((s+1)*p - s) + firstNum;
        },
        
        backEaseOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            var s = 1.70158; // default overshoot value, can be adjusted to suit
            return c*((p=p/1-1)*p*((s+1)*p + s) + 1) + firstNum;
        },
        
        backEaseInOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            var s = 1.70158; // default overshoot value, can be adjusted to suit
            if ((p/=0.5) < 1) 
                return c/2*(p*p*(((s*=(1.525))+1)*p - s)) + firstNum;
            else
                return c/2*((p-=2)*p*(((s*=(1.525))+1)*p + s) + 2) + firstNum;
        },
        
        // ******* bounce
        bounceEaseIn:function(p, n, firstNum, diff) {
            
            var c=firstNum+diff;
            var inv = this.bounceEaseOut (1-p, 1, 0, diff);
            return c - inv + firstNum;
        },
        
        bounceEaseOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;

            if (p < (1/2.75))
            {
                return c*(7.5625*p*p) + firstNum;
            }
            else if (p < (2/2.75))
            {
                return c*(7.5625*(p-=(1.5/2.75))*p + .75) + firstNum;
            }
            else if (p < (2.5/2.75))
            {
                return c*(7.5625*(p-=(2.25/2.75))*p + .9375) + firstNum;
            }
            else
            {
                return c*(7.5625*(p-=(2.625/2.75))*p + .984375) + firstNum;
            }
        },
        
        
        // ******* circ
        circEaseIn:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return -c * (Math.sqrt(1 - (p/=1)*p) - 1) + firstNum;
        },
        
        circEaseOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return c * Math.sqrt(1 - (p=p/1-1)*p) + firstNum;
        },
        
        circEaseInOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            if ((p/=0.5) < 1) 
                return -c/2 * (Math.sqrt(1 - p*p) - 1) + firstNum;
            else
                return c/2 * (Math.sqrt(1 - (p-=2)*p) + 1) + firstNum;
        },
        
        // ******* cubic
        cubicEaseIn:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return c*(p/=1)*p*p + firstNum;
        },
        
        cubicEaseOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return c*((p=p/1-1)*p*p + 1) + firstNum;
        },
        
        cubicEaseInOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            if ((p/=0.5) < 1)
                return c/2*p*p*p + firstNum;
            else
                return c/2*((p-=2)*p*p + 2) + firstNum;
        },
        
        // ******* elastic
        elasticEaseIn:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            if (p==0) return firstNum;
            if (p==1) return c;
            
            
            var peroid = 0.25;
            var s;
            var amplitude = c;
            
            if (amplitude < Math.abs(c)) 
            {
                amplitude = c;
                s = peroid/4;
            } 
            else 
            {
                s = peroid/(2*Math.PI) * Math.asin (c/amplitude);
            }
            
            return -(amplitude*Math.pow(2,10*(p-=1)) * Math.sin( (p*1-s)*(2*Math.PI)/peroid )) + firstNum;
        },
        
        elasticEaseOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            if (p==0) return firstNum;
            if (p==1) return c;
            
            var peroid = 0.25;
            var s;
            var amplitude = c;
            
            if (amplitude < Math.abs(c)) 
            {
                amplitude = c;
                s = peroid/4;
            } 
            else 
            {
                s = peroid/(2*Math.PI) * Math.asin (c/amplitude);
            }
        
            return -(amplitude*Math.pow(2,-10*p) * Math.sin( (p*1-s)*(2*Math.PI)/peroid )) + c;
        },
        
        // ******* expo
        expoEaseIn:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return (p==0) ? firstNum : c * Math.pow(2, 10 * (p - 1)) + firstNum - c * 0.001;
        },
        
        expoEaseOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return (p==1) ? c : diff * 1.001 * (-Math.pow(2, -10 * p) + 1) + firstNum;
        },
        
        expoEaseInOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            if (p==0) return firstNum;
            if (p==1) return c;
            
            if ((p/=0.5) < 1) 
                return c/2 * Math.pow(2, 10 * (p - 1)) + firstNum - c * 0.0005;
            else
                return c/2 * 1.0005 * (-Math.pow(2, -10 * --p) + 2) + firstNum;
        },
        
        // ******* quad
        quadEaseIn:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return c*(p/=1)*p + firstNum;
        },
        
        quadEaseOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return -c *(p/=1)*(p-2) + firstNum;
        },
        
        quadEaseInOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            if ((p/=0.5) < 1)
                return c/2*p*p + firstNum;
            else
                return -c/2 * ((--p)*(p-2) - 1) + firstNum;
        },

        // ******* quart
        quartEaseIn:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return c*(p/=1)*p*p*p + firstNum;
        },
        
        quartEaseOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return -c * ((p=p/1-1)*p*p*p - 1) + firstNum;
        },
        
        quartEaseInOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            if ((p/=0.5) < 1) 
                return c/2*p*p*p*p + firstNum;
            else
                return -c/2 * ((p-=2)*p*p*p - 2) + firstNum;
        },
        
        // ******* quint
        quintEaseIn:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return c*(p/=1)*p*p*p*p + firstNum;
        },
        
        quintEaseOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            return c*((p=p/1-1)*p*p*p*p + 1) + firstNum;
        },
        
        quintEaseInOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            
            if ((p/=0.5) < 1)
                return c/2*p*p*p*p*p + firstNum;
            else
                return c/2*((p-=2)*p*p*p*p + 2) + firstNum;
        },
        
        // *******  sine
        sineEaseIn:function(p, n, firstNum, diff) {
            
            var c=firstNum+diff;
            return -c * Math.cos(p * (Math.PI/2)) +c + firstNum; 
        },
        
        sineEaseOut:function(p, n, firstNum, diff) {
            
            var c=firstNum+diff;
            return c * Math.sin(p * (Math.PI/2)) + firstNum;
        },
        
        sineEaseInOut:function(p, n, firstNum, diff) {

            var c=firstNum+diff;
            return -c/2 * (Math.cos(Math.PI*p) - 1) + firstNum;
        }   
    }
});
