import {bodyLock, bodyLockStatus, bodyLockToggle, bodyUnlock} from './Helpers.js';

class Menu {
    constructor() {
        this.burger = document.querySelector('.burger')
        this.init();
    }

    init() {
        if (this.burger) {
            document.addEventListener('click', this.burgerHandler.bind(this));
        }
    }

    burgerHandler(e) {
        if (bodyLockStatus && e.target.closest('.burger')) {
            bodyLockToggle();
            document.documentElement.classList.toggle("menu-open");
        }
    }

    open() {
        bodyLock();
        document.documentElement.classList.add("menu-open");
    }

    close() {
        bodyUnlock();
        document.documentElement.classList.remove("menu-open");
    }
}

export default Menu;
