/* Author: Denis Petyukov <denis.petyukov@gmail.com> */

(function(){
    var getFirstEl = function(el) {
            return document.getElementsByTagName(el)[0];
        },
        body = getFirstEl('body'),
        header = getFirstEl('header'),
        logo = getFirstEl('a'),
        logoText = getFirstEl('p'),
        mainMenu = getFirstEl('ul'),
        postExcerpts = document.getElementsByTagName('div')[3],
        footer = getFirstEl('footer'),
    detectResolutionAndChangeStyle = function(){
        var currentWidth = parseInt(document.documentElement.clientWidth);
        
        if ( currentWidth > 800 ) {
            header.style.height = 156 + 'px';
            logo.style.top = 50 + 'px';
            logoText.style.top = 47 + 'px';
            mainMenu.style.left = 'auto';
            mainMenu.style.top = 47 + 'px';
        }
        else if ( currentWidth <= 800 && currentWidth > 320) {
            header.style.height = 100 + 'px';
            logo.style.top = 8 + 'px';
            logoText.style.top = 5 + 'px';
            logoText.style.display = 'block';
            mainMenu.style.left = 0;
            mainMenu.style.top = 50 + 'px';
            mainMenu.style.paddingLeft = 0;
        }
        else if ( currentWidth <= 320 ) {
            logoText.style.display = 'none';
        }
        
        if ( currentWidth <= 653 ) {
            postExcerpts.style.textAlign = 'center';
            footer.style.textAlign = 'center';
        }
        else if ( currentWidth > 653 ) {
            postExcerpts.style.textAlign = 'left';
            footer.style.textAlign = 'left';
        }

        if ( currentWidth <= 592 ) {
            body.style.margin = 0;
            header.style.marginLeft = 10 + 'px';
        }
        else if ( currentWidth > 592 ) {
            body.style.margin = 0 + ' ' + 10 + 'px';
            header.style.marginLeft = 0;
        }
    };

    detectResolutionAndChangeStyle();
    window.attachEvent('onresize', detectResolutionAndChangeStyle);
}());