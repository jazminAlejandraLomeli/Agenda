


export function clicSeePass(Id_button, id_input) {
    $(Id_button).off("click");
    $(Id_button).click(function (e) {
        if ($(id_input).attr("type") === "password") {
            $(id_input).attr("type", "text");
        } else {
            $(id_input).attr("type", "password");
        }
    });
}


