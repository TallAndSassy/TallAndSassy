window.addOrUpdateUrlParam = function (existingUrl, paramName, newValue) {
    let addr = new URL(existingUrl); //https://developer.mozilla.org/en-US/docs/Web/API/URL_API
    addr.searchParams.set(paramName, newValue);
    return addr.toString();
}
// This should be higher in the stack
window._urlChangedViaAjaxSoUpdateBrowserSoFeelsLikePageChange = function (newUrl) {
    console.log('pushing to browser history: ' + newUrl);
    history.pushState(null, null, newUrl);
    console.log('NewUrl: '+newUrl);
}
// This should be higher in the stack
window.onpopstate = function (event) {
    // https://www.quanzhanketang.com/jsref/met_loc_reload.html
    // https://developer.mozilla.org/en-US/docs/Web/API/History_API
    // https://stackoverflow.com/questions/29500484/window-onpopstate-is-not-working-nothing-happens-when-i-navigate-back-to-page
    // Fix back button 7/20' https://stackoverflow.com/questions/15394156/back-button-in-browser-not-working-properly-after-using-pushstate-in-chrome
    //
    location.reload();
}
