/* Author: Denis Petyukov <denis.petyukov@gmail.com> */

(function(){
    var audioPlayer = document.querySelectorAll('.audioPlayer'),
        l = audioPlayer.length,
        interval,
        progressMouseMove,
        soundMouseMove,
        documentMouseUp;
    for(i=0;i<l;i++) {
        audioPlayer[i].addEventListener('mousedown', function(e){
            e.preventDefault();
            var audio = this.querySelector('audio'),
                playAudio = this.querySelector('.playAudio'),
                progressBarWrap = this.querySelector('.progressBarWrap'),
                progressBar = this.querySelector('.progressBar'),
                mute = this.querySelector('.mute'),
                soundBarWrap = this.querySelector('.soundBarWrap'),
                soundBar = this.querySelector('.soundBar'),
                progressBarOffset = progressBar.getBoundingClientRect(),
                soundBarOffset = soundBar.getBoundingClientRect();
            if(e.target === playAudio) {
                if(audio.ended) {
                    progressBar.style.width = '0%';
                }
                if(audio.paused || audio.ended) {
                    audio.play();
                    playAudio.innerHTML = 'Pause';
                    playAudio.className = playAudio.className.replace(' paused', '') + ' playing';
                    interval = setInterval(function(){
                        progressBar.style.width = 100/audio.duration*audio.currentTime + '%';
                        if(audio.ended) {
                            clearInterval(interval);
                            playAudio.innerHTML = 'Play';
                            playAudio.className = playAudio.className.replace(' playing', '') + ' paused';
                        }
                    }, 500);
                } else {
                    audio.pause();
                    playAudio.innerHTML = 'Play';
                    playAudio.className = playAudio.className.replace(' playing', '') + ' paused';
                    clearInterval(interval);
                }
            }
            else if(e.target === progressBarWrap || e.target === progressBar) {
                clearInterval(interval);
                progressBar.style.width = 100/progressBarWrap.offsetWidth*(e.clientX-progressBarOffset.left) + '%';
                progressMouseMove = function(e) {
                    progressBar.style.width = 100/progressBarWrap.offsetWidth*(e.clientX-progressBarOffset.left) + '%';
                    if(e.clientX-progressBarOffset.left < 0) {
                        progressBar.style.width = '0%';
                    }
                }
                documentMouseUp = function(e) {
                    document.removeEventListener('mousemove', progressMouseMove, false);
                    audio.currentTime = audio.duration/100*parseFloat(progressBar.style.width);
                    if(audio.paused === false) {
                        interval = setInterval(function(){
                            progressBar.style.width = 100/audio.duration*audio.currentTime + '%';
                            if(audio.ended) {
                                clearInterval(interval);
                                playAudio.innerHTML = 'Play';
                                playAudio.className = playAudio.className.replace(' playing', '') + ' paused';
                            }
                        }, 500);
                    }
                    document.removeEventListener('mouseup', documentMouseUp, false);
                }
                document.addEventListener('mousemove', progressMouseMove, false);
                document.addEventListener('mouseup', documentMouseUp, false);
            }
            else if(e.target === mute) {
                if(audio.muted) {
                    audio.muted = false;
                    mute.innerHTML = 'Mute';
                    mute.className = mute.className.replace(' muted', '') + ' unmuted';
                    soundBar.style.width = 100*audio.volume + '%';
                } else {
                    audio.muted = true;
                    mute.innerHTML = 'Unmute';
                    mute.className = mute.className.replace(' unmuted', '') + ' muted';
                    soundBar.style.width = '0%';
                }
                if(audio.volume === 0) {
                    audio.volume = 0.3;
                    soundBar.style.width = 100*audio.volume + '%';
                }
                if(parseInt(soundBar.style.width) <= 50 && parseInt(soundBar.style.width) > 0) {
                    mute.className = mute.className.replace(' halfVolume', '') + ' halfVolume';
                }
                else {
                    mute.className = mute.className.replace(' halfVolume', '');
                }
            }
            else if(e.target === soundBarWrap || e.target === soundBar) {
                soundBar.style.width = 100/soundBarWrap.offsetWidth*(e.clientX-soundBarOffset.left) + '%';
                audio.volume = 1/100*parseFloat(soundBar.style.width);
                soundMouseMove = function(e) {
                    soundBar.style.width = 100/soundBarWrap.offsetWidth*(e.clientX-soundBarOffset.left) + '%';
                    if(e.clientX-soundBarOffset.left < 0) {
                        soundBar.style.width = '0%';
                    }
                    if(parseFloat(soundBar.style.width) <= 100) {
                        audio.volume = 1/100*parseFloat(soundBar.style.width);
                    }
                    if(audio.volume>0) {
                        audio.muted = false;
                        mute.innerHTML = 'Mute';
                        mute.className = mute.className.replace(' muted', '').replace(' unmuted', '') + ' unmuted';
                    } else {
                        audio.muted = true;
                        mute.innerHTML = 'Unmute';
                        mute.className = mute.className.replace(' unmuted', '').replace(' muted', '') + ' muted';
                    }
                    if(parseInt(soundBar.style.width) <= 50 && parseInt(soundBar.style.width) > 0) {
                        mute.className = mute.className.replace(' halfVolume', '') + ' halfVolume';
                    }
                    else {
                        mute.className = mute.className.replace(' halfVolume', '');
                    }
                }
                documentMouseUp = function(e) {
                    document.removeEventListener('mousemove', soundMouseMove, false);
                    document.removeEventListener('mouseup', documentMouseUp, false);
                }
                document.addEventListener('mousemove', soundMouseMove, false);
                document.addEventListener('mouseup', documentMouseUp, false);
                if(audio.volume>0) {
                    audio.muted = false;
                    mute.innerHTML = 'Mute';
                    mute.className = mute.className.replace(' muted', '').replace(' unmuted', '') + ' unmuted';
                } else {
                    audio.muted = true;
                    mute.innerHTML = 'Unmute';
                    mute.className = mute.className.replace(' unmuted', '').replace(' muted', '') + ' muted';
                }
                if(parseInt(soundBar.style.width) <= 50 && parseInt(soundBar.style.width) > 0) {
                    mute.className = mute.className.replace(' halfVolume', '') + ' halfVolume';
                }
                else if(parseInt(soundBar.style.width) > 50) {
                    mute.className = mute.className.replace(' halfVolume', '');
                }
            }
        },false);
        audioPlayer[i].addEventListener('click', function(e){e.preventDefault()}, false);
    }
}());