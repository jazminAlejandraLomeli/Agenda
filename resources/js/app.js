import './bootstrap';
import $ from "jquery";

import "animate.css";
import "flowbite";

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'

Alpine.plugin(collapse)

window.Alpine = Alpine;

window.$ = $;
window.jQuery = $;

Alpine.start();
