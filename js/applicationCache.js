// applicationCache
// http://www.html5rocks.com/de/tutorials/appcache/beginner/

var appCache = window.applicationCache;
appCache.update();
console.log(appCache.status);

if (appCache.status == window.applicationCache.UPDATEREADY) {
    appCache.swapCache();
}
