// eslint-disable-next-line
WebFontConfig = {
  google: {
    families: ['Droid Sans', 'Droid Serif']
  },
  timeout: 2000,
  active: function() { clearFout(); },
  inactive: function() { clearFout(); }
};

function clearFout() {
  sessionStorage.fonts = true;
}

(function(d) {
  var wf = d.createElement('script'), s = d.scripts[0];
  wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js';
  s.parentNode.insertBefore(wf, s);
  if(sessionStorage.fonts) {
    d.getElementsByTagName('html')[0].classList.add('wf-active');
  }
})(document);
