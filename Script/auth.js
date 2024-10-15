$(() => {
    const inputContainer = $(".input-container");
    const inputs = $(".input-container input");

    inputContainer.on('click', (e) => {
        const input = $(e.currentTarget).find("input");
        const label = $(e.currentTarget).find("label");

        label.css({
            "top": "-25%"
        });
        input.focus();
    });

    inputs.on('focus', function() {
        
        const label = $(this).siblings("label");
        label.css({
            "top": "-25%"
        });
    });

    inputContainer.find("input").on('blur', function() {
        const input = $(this);
        const label = input.siblings("label");

        if (input.val().trim() === "") {
            label.css({
                "top": "50%"
            });
        }
    });
});
