

        //Show hide dates popover
        var displayPopover = 1;
        function togglePopover() {

            if (displayPopover % 2 === 0) {
                document.getElementById("datePopover").style.opacity = 0;

                setTimeout(function () {
                    document.getElementById("datePopover").classList.remove("visible");
                    document.getElementById("datePopover").classList.add("invisible");
                }, 300);

            } else {
                document.getElementById("datePopover").classList.remove("invisible");
                document.getElementById("datePopover").classList.add("visible");
                document.getElementById("datePopover").style.opacity = 1;

            }
            displayPopover++;
        }

        function closePopover() {
            document.getElementById("datePopover").style.opacity = 0;

            setTimeout(function () {
                document.getElementById("datePopover").classList.remove("visible");
                document.getElementById("datePopover").classList.add("invisible");
            }, 300);

            displayPopover = 1;
        }



        window.onload = function () {
            document.getElementById("datePopoverBtn").addEventListener("click", togglePopover);
            document.getElementsByClassName("close")[0].addEventListener("click", closePopover);

            $(".alert-success").slideDown(400);

            $(".alert-success").delay(6000).slideUp(400, function () {
                $(this).alert('close');
            });

        };


