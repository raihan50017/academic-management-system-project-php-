(function ($) {
    "use strict";


    /*-------------------------------------
      Sidebar Toggle Menu
    -------------------------------------*/
    $('.sidebar-toggle-view').on('click', '.sidebar-nav-item .nav-link', function (e) {
        if (!$(this).parents('#wrapper').hasClass('sidebar-collapsed')) {
            var animationSpeed = 300,
                subMenuSelector = '.sub-group-menu',
                $this = $(this),
                checkElement = $this.next();
            if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
                checkElement.slideUp(animationSpeed, function () {
                    checkElement.removeClass('menu-open');
                });
                checkElement.parent(".sidebar-nav-item").removeClass("active");
            } else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
                var parent = $this.parents('ul').first();
                var ul = parent.find('ul:visible').slideUp(animationSpeed);
                ul.removeClass('menu-open');
                var parent_li = $this.parent("li");
                checkElement.slideDown(animationSpeed, function () {
                    checkElement.addClass('menu-open');
                    parent.find('.sidebar-nav-item.active').removeClass('active');
                    parent_li.addClass('active');
                });
            }
            if (checkElement.is(subMenuSelector)) {
                e.preventDefault();
            }
        } else {
            if ($(this).attr('href') === "#") {
                e.preventDefault();
            }
        }
    });



    /*-------------------------------------
      Sidebar Menu Control
    -------------------------------------*/
    $(".sidebar-toggle").on("click", function () {
        window.setTimeout(function () {
            $("#wrapper").toggleClass("sidebar-collapsed");
        }, 500);
    });

    /*-------------------------------------
         Sidebar Menu Control Mobile
    -------------------------------------*/
    $(".sidebar-toggle-mobile").on("click", function () {
        $("#wrapper").toggleClass("sidebar-collapsed-mobile");
        if ($("#wrapper").hasClass("sidebar-collapsed")) {
            $("#wrapper").removeClass("sidebar-collapsed");
        }
    });

    /*-------------------------------------
         Counter Control
    -------------------------------------*/

    jQuery(document).ready(function ($) {
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    });


    /*-------------------------------------
          Doughnut Chart 
      -------------------------------------*/
    if ($("#student-doughnut-chart").length) {

        var doughnutChartData = {
            labels: ["Female Students", "Male Students"],
            datasets: [{
                backgroundColor: ["#304ffe", "#ffa601"],
                data: [45000, 105000],
                label: "Total Students"
            },]
        };
        var doughnutChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 0,
            rotation: -9.4,
            animation: {
                duration: 2000
            },
            legend: {
                display: false
            },
            tooltips: {
                enabled: true
            },
        };
        var studentCanvas = $("#student-doughnut-chart").get(0).getContext("2d");
        var studentChart = new Chart(studentCanvas, {
            type: 'pie',
            data: doughnutChartData,
            options: doughnutChartOptions
        });
        console.log(studentChart);
    }


    $(function () {
        /*-------------------------------------
                Data Table init
        -------------------------------------*/
        if ($.fn.DataTable !== undefined) {
            $('.data-table').DataTable({
                paging: true,
                ordering: false,
                searching: true,
                info: false,
                lengthChange: false,
                lengthMenu: [20, 50, 75, 100],
                columnDefs: [{
                    targets: [0, -1], // column or columns numbers
                    orderable: false // set orderable for selected columns
                }],
            });
        }

        /*-------------------------------------
          All Checkbox Checked
        -------------------------------------*/
        $(".checkAll").on("click", function () {
            $(this).parents('.table').find('input:checkbox').prop('checked', this.checked);
        });

        /*-------------------------------------
          Select 2 Init
      -------------------------------------*/
        if ($.fn.select2 !== undefined) {
            $('.select2').select2({
                width: '100%'
            });
        }

        /*-------------------------------------
              Date Picker
          -------------------------------------*/
        if ($.fn.datepicker !== undefined) {
            $('.air-datepicker').datepicker({
                language: {
                    days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    today: 'Today',
                    clear: 'Clear',
                    dateFormat: 'dd/mm/yyyy',
                    firstDay: 0
                }
            });
        }

    })


})(jQuery);

