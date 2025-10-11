import { showLoader } from "./loader";

export default class ChangeColorCalendar {
    constructor() {
        this.initElements();
        this.initLocalStorage();
        this.initEventListeners();
        this.applyInitialStyles();
    }

    initElements() {
        this.colorSolido = document.getElementById("color-solido");
        this.colorOpacidad = document.getElementById("color-opacidad");
        this.optionsDesign = this.getCheckboxOptions();
    }

    initLocalStorage() {
        if (!localStorage.getItem("colorCalendar")) {
            localStorage.setItem("colorCalendar", "designOpacity");
            this._colorCalendar = "33";
        } else {
            this._colorCalendar =
                localStorage.getItem("colorCalendar") === "designSolid"
                    ? ""
                    : "22";
        }
    }

    initEventListeners() {
        this.optionsDesign.forEach((option) => {
            option.addEventListener(
                "change",
                this.manageChangeOption.bind(this)
            );
        });
    }

    applyInitialStyles() {
        this.optionsDesign.forEach((option) => {
            option.checked =
                localStorage.getItem("colorCalendar") === option.value;
        });
    }

    getCheckboxOptions() {
        return document.querySelectorAll(
            '#options-design li div input[type="checkbox"]'
        );
    }

    resetCheckboxOptions(value) {
        this.optionsDesign.forEach((option) => {
            if (option.checked && option.value !== value) {
                option.checked = false;
            }
        });
    }

    manageChangeOption(e) {
        this.resetCheckboxOptions(e.target.value);

        if (e.target.checked) {
            localStorage.setItem("colorCalendar", e.target.value);
            this._colorCalendar = e.target.value;
            this.applyColor();
        }
    }

    applyColor() {
        showLoader('Aplicando estilos a los eventos');
        location.reload();
    }

    get colorCalendar() {
        return this._colorCalendar;
    }
}
