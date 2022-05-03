import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';
UIkit.use(Icons);
window.UIkit = UIkit;

const {$,once,remove,transition,} = UIkit.util;
window.onload = () => {
    const loader = $('#preloader');
    transition(loader, { opacity: 0 });
    once(loader, 'transitionend', () => remove(loader));
};
