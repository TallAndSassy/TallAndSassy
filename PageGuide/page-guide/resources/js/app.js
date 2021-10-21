// ---- HACK: Look for these two imports in /resources/js/app.js ---
// import persist from '@alpinejs/persist'
// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// window.persist = persist;
// ------------------------------------------------------------------
// These two imports caused the following when put here, they need to go into the root /resousource/js/app.js
// So, I think this is mainly because I don't understand webpack et. al.
// ERROR in ../TallAndSassy/PageGuide/page-guide/resources/js/app.js 1:0-40
// Module not found: Error: Can't resolve '@alpinejs/persist' in '/Users/jjrohrer/Sites/eh/TallAndSassy/TallAndSassyPackageDev/TallAndSassy/PageGuide/page-guide/resources/js'
//
// ERROR in ../TallAndSassy/PageGuide/page-guide/resources/js/app.js 2:0-30
// Module not found: Error: Can't resolve 'alpinejs' in '/Users/jjrohrer/Sites/eh/TallAndSassy/TallAndSassyPackageDev/TallAndSassy/PageGuide/page-guide/resources/js'
// WTH*ck.
