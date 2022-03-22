$(document).ready(function() {
    load_menu();
    load_content();
})

function load_menu() {
    set_spinner($("#sidebar"))        
    $("#sidebar").load("/content/sidebar/sidebar.php")
}

function load_content() {
    set_spinner($("#content"))        
    var url = location.href.split("/").splice(3);
    $("#content").load("/content/get_content.php?data="+JSON.stringify(url))

}

function set_spinner(target) {
    target.html('<div class="spinner-area"><div><i class="fa-solid fa-spinner fa-spin"></i></div></div>')
}