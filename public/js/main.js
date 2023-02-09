var clipboard = new ClipboardJS('.btn');

$("#authorize").submit(function (event) {
    event.preventDefault();

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        success: function (data) {
            window.location.replace("/");
        },
        error: function (data) {
            alert(data.responseText);
        }
    });
});

$("#register").submit(function (event) {
    event.preventDefault();

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        success: function (data) {
            window.location.replace("/");
        },
        error: function (data) {
            alert(data.responseText);
        }
    });
});

$("#shorter").submit(function (event) {
    event.preventDefault();

    $.ajax({
        type: "POST",
        data: $(this).serialize(),
        success: function (data) {
            if (data == true) {
                window.location.replace("/");
            } else {
                $("#clipboard").val(data);
                $(".clipboard").show();
            }
        },
        error: function (data) {
            alert(data.responseText);
        }
    });
});