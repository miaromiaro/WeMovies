var $ = require('jquery');
window.$ = $;
window.jQuery = $;

const routes = require('./Routing');
import Routing from '../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

$(".modal-movie").on('hidden.bs.modal', function (e) {
    var id = $(this).data("id");
    $("#modal-movie-"+id+" iframe").attr("src", $("#modal-movie-"+id+" iframe").attr("src"));
});

$(document).on('change', '.genreCheckbox', function(event){
    var tabGenreChecked = [];
    $('input.genreCheckbox:checkbox:checked').each(function () {
        tabGenreChecked.push($(this).val());
    });

    var genreChecked = tabGenreChecked.join(",");
    var id = $(this).val();
    $.ajax({
        type: 'get',
        url: Routing.generate('moviesByGenre', {idGenre: id}, true),
        success: function (data) {
            $('#listMovies').empty().append(data)
        }
    });


})
