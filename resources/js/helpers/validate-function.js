/* Funcion para validar los campos segun su contenido con la expresion Regular, y marcando el error con rojo */
export function validarCampo(valor, regex, campo) {
    if (!regex.test(valor)) {
        // Borde rojo y animacion perroncilla
        
        $(campo)
            .parent()
            .addClass(
                "border border-red-500 animate__animated animate__headShake"
            );

        //  eliminar animacion perroncilla
        $(campo)
            .parent()
            .one(
                "animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd",
                function () {
                    $(this).removeClass("animate__animated animate__headShake");
                }
            );

        return false;
    } else {
        // Eliminar
        $(campo).parent().removeClass("border border-red-500");
        return true;
    }
}

/*
    Funcion para mostrar u ocultar la alerta de error ene l modal
*/
export function ShowOrHideAlert(Type, campo) {
    if (Type == 1) {
        // Ocultar alerta
        if (!$(campo).hasClass("hidden")) {
            $(campo).addClass("hidden");
        }
    } else {
        //mostrar alerta
        if ($(campo).hasClass("hidden")) {
            $(campo).removeClass("hidden").hide().fadeIn(400);
        }
    }
}
