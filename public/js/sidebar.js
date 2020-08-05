$(document).ready(function () {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal",
    });
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#sidebarCollapseIcon').toggleClass('fa-angle-double-left');
        $('#sidebarCollapseIcon').toggleClass('fa-angle-double-right');
        $('#content-of-sidebar').toggleClass('active');
    });
});
