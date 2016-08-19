$(document).ready(
    function() {
        $("#sort").sortable({
          update: function() {
            serial = $('#sort').sortable('serialize');
            $.ajax({
                url: "sort.php",
                type: "post",
                data: serial,
                error: function() {
                    alert("theres an error with AJAX");
                }
            });
        }
    });
});