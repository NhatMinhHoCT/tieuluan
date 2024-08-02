(function ($) {
  "use strict";

  // Spinner
  let spinner = function () {
    setTimeout(function () {
      if ($("#spinner").length > 0) {
        $("#spinner").removeClass("show");
      }
    }, 1);
  };
  spinner();

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  });
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
    return false;
  });

  // Sidebar Toggler
  $(".sidebar-toggler").click(function () {
    $(".sidebar, .content").toggleClass("open");
    return false;
  });

  // Progress Bar
  $(".pg-bar").waypoint(
    function () {
      $(".progress .progress-bar").each(function () {
        $(this).css("width", $(this).attr("aria-valuenow") + "%");
      });
    },
    { offset: "80%" }
  );

  // Calender
  $("#calender").datetimepicker({
    inline: true,
    format: "L",
  });

  // Testimonials carousel
  $(".testimonial-carousel").owlCarousel({
    autoplay: true,
    smartSpeed: 1000,
    items: 1,
    dots: true,
    loop: true,
    nav: false,
  });

  // Chart Global Color
  Chart.defaults.color = "#6C7293";
  Chart.defaults.borderColor = "#72AEC8";

  // Worldwide Sales Chart
  let ctx1 = $("#barChart").get(0).getContext("2d");
  let mychart = new Chart(ctx1, {
    type: "bar",
    data: {
      labels: chartData.map(function (item) {
        return item.year;
      }),
      datasets: [
        {
          backgroundColor: [
            "rgba(114, 174, 200, .7)",
            "rgba(114, 174, 200, .6)",
            "rgba(114, 174, 200, .5)",
            "rgba(114, 174, 200, .4)",
            "rgba(114, 174, 200, .3)",
          ],
          data: chartData.map(function (item) {
            return item.record_count;
          }),
        },
      ],
    },
    options: {
      responsive: true,
    },
  });
  // mychart.data.datasets[0].data=newData;
  // mychart.update();
  myChart.options.scales.y.min = 0;
  myChart.options.scales.y.max = 100;
  myChart.update();

  // let ctx1 = $("#barChart").get(0).getContext("2d");
  // let myChart1 = new Chart(ctx1, {
  //     type: "bar",
  //     data: {
  //         labels: ["Italy", "France", "Spain", "USA", "Argentina"],
  //         datasets: [{
  //             backgroundColor: [
  //                 "rgba(114, 174, 200, .7)",
  //                 "rgba(114, 174, 200, .6)",
  //                 "rgba(114, 174, 200, .5)",
  //                 "rgba(114, 174, 200, .4)",
  //                 "rgba(114, 174, 200, .3)"
  //             ],
  //             data: [55, 49, 44, 24, 15]
  //         }]
  //     },
  //     options: {
  //         responsive: true
  //     }
  // });
  // let myChart1 = new Chart(ctx1, {
  //     type: "bar",
  //     data: {
  //         labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
  //         datasets: [{
  //                 label: "USA",
  //                 data: [15, 30, 55, 65, 60, 80, 95],
  //                 backgroundColor: "rgba(114, 174, 200, .7)"
  //             },
  //             {
  //                 label: "UK",
  //                 data: [8, 35, 40, 60, 70, 55, 75],
  //                 backgroundColor: "rgba(114, 174, 200, .5)"
  //             },
  //             {
  //                 label: "AU",
  //                 data: [12, 25, 45, 55, 65, 70, 60],
  //                 backgroundColor: "rgba(114, 174, 200, .3)"
  //             }
  //         ]
  //         },
  //     options: {
  //         responsive: true
  //     }
  // });

  // Salse & Revenue Chart
  let ctx2 = $("#salse-revenue").get(0).getContext("2d");
  let mychart2 = new Chart(ctx2, {
    type: "line",
    data: {
      labels: ["2016", "2017", "2018", "2019", "2020", "2021", "2022"],
      datasets: [
        {
          label: "Salse",
          data: [15, 30, 55, 45, 70, 65, 85],
          backgroundColor: "rgba(114, 174, 200, .7)",
          fill: true,
        },
        {
          label: "Revenue",
          data: [99, 135, 170, 130, 190, 180, 270],
          backgroundColor: "rgba(114, 174, 200, .5)",
          fill: true,
        },
      ],
    },
    options: {
      responsive: true,
    },
  });

  mychart2.data.datasets[0].data = newData;
  mychart2.update();

  // Single Line Chart
  let ctx3 = $("#line-chart").get(0).getContext("2d");
  let myChart3 = new Chart(ctx3, {
    type: "line",
    data: {
      labels: [50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150],
      datasets: [
        {
          label: "Salse",
          fill: false,
          backgroundColor: "rgba(235, 22, 22, .7)",
          data: [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15],
        },
      ],
    },
    options: {
      responsive: true,
    },
  });

  // Single Bar Chart
  let ctx4 = $("#bar-chart").get(0).getContext("2d");
  let myChart4 = new Chart(ctx4, {
    type: "bar",
    data: {
      labels: ["Italy", "France", "Spain", "USA", "Argentina"],
      datasets: [
        {
          backgroundColor: [
            "rgba(235, 22, 22, .7)",
            "rgba(235, 22, 22, .6)",
            "rgba(235, 22, 22, .5)",
            "rgba(235, 22, 22, .4)",
            "rgba(235, 22, 22, .3)",
          ],
          data: [55, 49, 44, 24, 15],
        },
      ],
    },
    options: {
      responsive: true,
    },
  });

  // Pie Chart
  let ctx5 = $("#pie-chart").get(0).getContext("2d");
  let myChart5 = new Chart(ctx5, {
    type: "pie",
    data: {
      labels: ["Italy", "France", "Spain", "USA", "Argentina"],
      datasets: [
        {
          backgroundColor: [
            "rgba(235, 22, 22, .7)",
            "rgba(235, 22, 22, .6)",
            "rgba(235, 22, 22, .5)",
            "rgba(235, 22, 22, .4)",
            "rgba(235, 22, 22, .3)",
          ],
          data: [55, 49, 44, 24, 15],
        },
      ],
    },
    options: {
      responsive: true,
    },
  });

  // Doughnut Chart
  let ctx6 = $("#doughnut-chart").get(0).getContext("2d");
  let myChart6 = new Chart(ctx6, {
    type: "doughnut",
    data: {
      labels: ["Italy", "France", "Spain", "USA", "Argentina"],
      datasets: [
        {
          backgroundColor: [
            "rgba(235, 22, 22, .7)",
            "rgba(235, 22, 22, .6)",
            "rgba(235, 22, 22, .5)",
            "rgba(235, 22, 22, .4)",
            "rgba(235, 22, 22, .3)",
          ],
          data: [55, 49, 44, 24, 15],
        },
      ],
    },
    options: {
      responsive: true,
    },
  });
})(jQuery);
// Toast function
function toast({ title = "", message = "", type = "info", duration = 3000 }) {
  const main = document.getElementById("toast");
  if (main) {
    const toast = document.createElement("div");

    // Auto remove toast
    const autoRemoveId = setTimeout(function () {
      main.removeChild(toast);
    }, duration + 1000);

    // Remove toast when clicked
    toast.onclick = function (e) {
      if (e.target.closest(".toast__close")) {
        main.removeChild(toast);
        clearTimeout(autoRemoveId);
      }
    };

    const icons = {
      success: "fas fa-check-circle",
      info: "fas fa-info-circle",
      warning: "fas fa-exclamation-circle",
      error: "fas fa-exclamation-circle",
    };
    const icon = icons[type];
    const delay = (duration / 1000).toFixed(2);

    toast.classList.add("toast", `toast--${type}`);
    toast.style.animation = `slideInLeft ease .3s, fadeOut linear 1s ${delay}s forwards`;

    toast.innerHTML = `
                    <div class="toast__icon">
                        <i class="${icon}"></i>
                    </div>
                    <div class="toast__body">
                        <h3 class="toast__title">${title}</h3>
                        <p class="toast__msg">${message}</p>
                    </div>
                    <div class="toast__close">
                        <i class="fas fa-times"></i>
                    </div>
                `;
    main.appendChild(toast);
  }
}
function showToast(title, message, type) {
  toast({
    title: title,
    message: message,
    type: type,
    duration: 1500,
  });
}
