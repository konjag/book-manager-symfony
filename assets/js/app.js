/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('semantic-ui-css/semantic.min.css');
require('../scss/app.scss');

var $ = require('jquery');
window.$ = window.jQuery = $;

require('semantic-ui-css/semantic.min');

require('./main');
