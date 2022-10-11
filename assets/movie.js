var $ = require('jquery');
window.$ = $;
window.jQuery = $;

function addCache() {
    if ($("#cache").length != 0) {
        return true;
    }
    $("body").append("<div id='cache' style='position:fixed;top:0px; height: 100%; width: 100%; background: rgba(0,0,0,0.3); z-index: 9999;text-align:center;padding-top:25%'><div class='loader'><img src=" + srcImgLoader + " alt=''></div></div>");
}

function removeCache() {
    $("#cache").remove();
}

//When modal is closed
$(".modal-movie").on('hidden.bs.modal', function (e) {
    var id = $(this).data("id");
    $('.content-'+id).empty();
    /*$("#modal-movie-"+id+" iframe").attr("src", $("#modal-movie-"+id+" iframe").attr("src"));*/
});

//Click on ckeckbox, load movie list
$(document).on('click', 'input:checkbox', function(event){
    addCache();
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
            removeCache();
        }
    });
});

//Open popup when click more detail
$(document).on('click', '.detailMovie', function(event){
    addCache();
    var id = $(this).data("id");
    $('#modal-movie-'+id).show();
    var url = 'detailMovie/'+id;

    $.ajax({
        async:true,
        type: 'get',
        url: url,
        success: function (data) {
            $('.content-'+id).empty().append(data);
            removeCache();
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
    addCache();
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
                removeCache();
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