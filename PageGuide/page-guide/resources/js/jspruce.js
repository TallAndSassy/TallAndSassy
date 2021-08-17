

// ------------------------ jspruce modals -BEGIN- ---------------------------------------------------------------------
// test Spruce is working
console.log('start spruce test');
window.Spruce.store('sprucetest_modal', {
    open: 'login',
});
// console.log($store.sprucetest_modal.open);
window.Spruce.store('sprucemodal', {
    doShowModal: false,
    diy: false,
    loadingButtonText: 'Close',
    loadingButtonClasses: 'bg-gray-300',
    loadingButtonContainerClasses: 'bg-gray-50 sm:grid sm:grid-1',
    loadingTitle: 'Loading',  //not seeing it passed in ?



    renderSource: 'tbd',

    'buttonText': 'tbd',
    'title': 'tbd',
    'buttonClasses':'bg-green-200 hover:bg-green-300',
    'isLoaded_buttonClasses':'',
    'buttonContainerClasses': '',
    'isLoaded': false,

    innerHtml: '',
})
console.log('end spruce test');

// ------------------------ jspruce modals -END- -----------------------------------------------------------------------

