/*var $ = require('jquery');
window.$ = $;
window.jQuery = $;*/

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/custom.scss'
require('bootstrap-icons/font/bootstrap-icons.css');

//import boostrap
import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';
