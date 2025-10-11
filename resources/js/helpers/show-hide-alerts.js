export function showHideAlert(type, id_alert, title, text) {
     const alertElement = $(id_alert);
    const titleElement = alertElement.find(".title-alert");
    const textElement = alertElement.find(".text-alert");
    if (type == 1) {
        // Show alert
        if (alertElement.hasClass("hidden")) {
            alertElement.removeClass("hidden");
        }
        titleElement.text(title);
        textElement.text(text);
    } else {
        // Hidden
        if (!alertElement.hasClass("hidden")) {
            alertElement.addClass("animate__animated animate__fadeOutUp");
            alertElement.one(
                "animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd",
                function () {
                    alertElement.addClass("hidden");
                    alertElement.removeClass(
                        "animate__animated animate__fadeOutUp"
                    );
                }
            );
        }
    }
}
