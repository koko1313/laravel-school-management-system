$(document).ready(function () {
    // За контекстноте меню на оценките
        $(".grade-context-menu").menu();

        $(".grades").on("contextmenu", function() {
            return false;
        });

        $(document).select(function() {
            return false;
        });

        $(document).click(function() {
            $(".grade-context-menu").hide();
        });
    // Край на За контекстното меню на оценките

    // подкарва tooltip-овете
    $('[data-toggle="tooltip"]').tooltip({
        delay: { "show": 500 }
    });
});
