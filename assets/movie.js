var $ = require('jquery');
window.$ = $;
window.jQuery = $;

//When modal is closed
$(".modal-movie").on('hidden.bs.modal', function (e) {
    var id = $(this).data("id");
    $('.content-'+id).empty();
    /*$("#modal-movie-"+id+" iframe").attr("src", $("#modal-movie-"+id+" iframe").attr("src"));*/
});

//Click on ckeckbox, load movie list
$(document).on('click', 'input:checkbox', function(event){
    var group = "input:checkbox[name='" + $(this).prop("name") + "']";
    $(group).prop("checked", false);
    $(this).prop("checked", true);
    var url = 'moviesByGenre/'+$(this).val();

    getTopMovieFromGenreSelected($(this).val());

    $.ajax({
        type: 'get',
        url: url,
        success: function (data) {
            $('#listMovies').empty().append(data);
        }
    });
});

//Open popup when click more detail
$(document).on('click', '.detailMovie', function(event){
    var id = $(this).data("id");
    $('#modal-movie-'+id).show();
    var url = 'detailMovie/'+id;

    $.ajax({
        async:true,
        type: 'get',
        url: url,
        success: function (data) {
            $('.content-'+id).empty().append(data);
        }
    });
})

//Load the main trailer
function getTopMovieFromGenreSelected(genre){
    var url = 'topMovie/'+genre;
    $.ajax({
        async:true,
        type: 'get',
        url: url,
        success: function (data) {
            $('.frame-trailer').empty().append(data);
        }
    });
}

//Find Movie
$(document).on('click', '#search-bar-icon', function(event){
    var textToFind = $('input#search-bar').val();
    if(textToFind?.trim()!==""){
        var url = 'findMovie/'+textToFind;

        $.ajax({
            type: 'get',
            url: url,
            success: function (data) {
                $('#listMovies').empty().append(data);
                var group = ".genreCheckbox";
                $(group).prop("checked", false);
                $('input#search-bar').val('');
            }
        });
    }

});

$(document).on('keydown', '#formMovie', function(event){
    if(event.keyCode === 13) {
        event.preventDefault();
        $('#search-bar-icon').trigger('click');
        return false;
    }
});
