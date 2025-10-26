<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>NSPOMdb</title>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo.png">
    <link rel="manifest" href="phoenix/public/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="phoenix/public/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="phoenix/public/vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="phoenix/public/vendors/simplebar/simplebar.min.js"></script>
    <script src="phoenix/public/assets/js/config.js"></script>
    <script src="assets/js/echarts.min.js"></script>
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================--> 
    <link href="phoenix/public/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="phoenix/public/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="phoenix/public/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="phoenix/public/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="phoenix/public/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
    <link href="assets/css/style.css" type="text/css" rel="stylesheet" id="custom-style-default">
    <script>
      var phoenixIsRTL = window.config.config.phoenixIsRTL;
      if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
  </head>
  <?php
    session_start();
  ?>

  <body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container-fluid px-0">
        <nav class="navbar navbar-vertical navbar-expand-lg">
          <script>
            var navbarStyle = window.config.config.phoenixNavbarStyle;
            if (navbarStyle && navbarStyle !== 'transparent') {
              document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
            }
          </script>
        </nav>
        <?php include 'scripts/navbarTop.php'; ?>
        <script>
          var navbarVertical = document.querySelector('.navbar-vertical');
          navbarVertical.remove();
          navbarTop.removeAttribute('style');
        </script>
        <div class="content container">
          <div class="row g-4">
            <div class="col-12 col-xl-6">
              <div class="card custom-shadow my-0">
                <div class="card-body p-0">
                  <div class="p-4 code-to-copy">
                    <h4 class="text-900 mb-0">Product characteristics</h4><hr>
                    <form class="row g-3">
                    <div class="col-12">
                      <label for="product_type">Product type</label>
                      <select class="form-select" id="product_type">
                        <option value=1>The product has significant antibacterial properties</option>
                        <option value=2>The product does not have significant antibacterial properties</option>
                        <option value=3>The product supports the growth of microorganisms</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label for="Sd">The maximum single dose (g or ml)</label>
                      <input class="form-control" id="Sd" value=10></input>
                    </div>
                    <div class="col-12">
                      <label for="tp">Antimicrobial efficacy test duration (day)</label>
                      <input class="form-control" id="tp" value=14></input>
                    </div>
                    <div class="col-12">
                      <label for="Ap">Antimicrobial efficacy test reduction amount (log CFU/g or CFU/ml)</label>
                      <input class="form-control" id="Ap" value=3.5></input>
                    </div>
                    <div class="col-12">
                      <label for="t">Time to reach the expected reduction amount (day)</label>
                      <input class="form-control" id="t" value=14></input>
                    </div>
                    </form>
                  </div>
                </div>             
              </div>
              <div class="mt-1 card custom-shadow my-0">
                <div class="card-body p-0">
                  <div class="p-4 code-to-copy">
                    <h4 class="text-900 mb-0">Monitoring information</h4><hr>
                    <form class="row g-3">
                    <div class="col-12">
                      <label for="Vc">Detected microbial contamination levels (CFU/g or CFU/ml)</label>
                      <input class="form-control" id="Vc" value=100></input>
                    </div>
                    <div class="col-12">
                      <label for="Fm">Target microorganism proportion (%)</label>
                      <input class="form-control" id="Fm" value=10></input>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-xl-6">
              <div class="card custom-shadow my-0">
                <div class="card-body p-0">
                  <div class="p-4 code-to-copy">
                    <h4 class="text-900 mb-0">Microorganism characteristics</h4><hr>
                    <form class="row g-3">
                    <div class="col-12">
                      <label for="ID">Minimum Infective Dose (CFU)</label>
                      <input class="form-control" id="ID" value=1000></input>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="row">
                <div id="grade_gauge" data-echart-responsive="data-echart-responsive" style="width: 1000px;height:500px;"></div>
              </div>
              <div class="row d-flex justify-content-center">
                <div class="col-auto">
                  <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">View calculation formula</button>
                  <div class="offcanvas offcanvas-end" id="offcanvasRight" tabindex="-1" aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                      <h5 id="offcanvasRightLabel">Calculation formula</h5>
                      <button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                      <img src="assets/img/formula.png" alt="Calculation formula" width="100%">
                      <small class="text-muted">
                        Reference: Eissa, M. E. (2016). Distribution of bacterial contamination in non-sterile pharmaceutical materials and assessment of its risk to the health of the final consumers quantitatively. <i>Beni-Suef University Journal of Basic and Applied Sciences</i>, 5(3), 217-230
                      </small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
        var navbarTop = document.querySelector('.navbar-top');
        if (navbarTopStyle === 'darker') {
          navbarTop.classList.add('navbar-darker');
        }
      </script>
      <?php include 'scripts/footer.php'; ?>
    </main>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="phoenix/public/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="phoenix/public/vendors/anchorjs/anchor.min.js"></script>
    <script src="phoenix/public/vendors/is/is.min.js"></script>
    <script src="phoenix/public/vendors/fontawesome/all.min.js"></script>
    <script src="phoenix/public/vendors/lodash/lodash.min.js"></script>
    <script src="phoenix/public/vendors/list.js/list.min.js"></script>
    <script src="phoenix/public/vendors/feather-icons/feather.min.js"></script>
    <script src="phoenix/public/vendors/dayjs/dayjs.min.js"></script>
    <script src="phoenix/public/assets/js/phoenix.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // 获取表单元素
        const productTypeEl = document.getElementById("product_type");
        const SdEl = document.getElementById("Sd");
        const tpEl = document.getElementById("tp");
        const ApEl = document.getElementById("Ap");
        const tEl = document.getElementById("t");
        const VcEl = document.getElementById("Vc");
        const FmEl = document.getElementById("Fm");
        const IDEl = document.getElementById("ID");

        // 初始化图表
        const chartDom = document.getElementById("grade_gauge");
        const myChart = echarts.init(chartDom);
        const option = {
          series: [
            {
              type: "gauge",
              startAngle: 180,
              endAngle: 0,
              center: ["50%", "75%"],
              radius: "90%",
              min: 0,
              max: 100,
              splitNumber: 8,
              axisLine: {
                lineStyle: {
                  width: 6,
                  color: [
                    [0.25, "#7CFFB2"], // 0-25: Low risk
                    [0.5, "#FDDD60"],  // 25-50: Medium risk
                    [1, "#FF6E76"],    // 50-100: High risk
                  ],
                },
              },
              pointer: {
                icon: "path://M12.8,0.7l12,40.1H0.7L12.8,0.7z",
                length: "12%",
                width: 20,
                offsetCenter: [0, "-60%"],
                itemStyle: { color: "auto" },
              },
              axisTick: { length: 12, lineStyle: { color: "auto", width: 2 } },
              splitLine: { length: 20, lineStyle: { color: "auto", width: 5 } },
              axisLabel: {
                color: "#464646",
                fontSize: 20,
                distance: -60,
                rotate: "tangential",
                formatter: function (value) {
                  if (value === 75) return "High risk";
                  else if (value === 37.5) return "Medium risk";
                  else if (value === 12.5) return "Low risk";
                  return "";
                },
              },
              title: { offsetCenter: [0, "-10%"], fontSize: 20 },
              detail: {
                fontSize: 30,
                offsetCenter: [0, "-35%"],
                valueAnimation: true,
                color: "inherit",
              },
              data: [{ value: 0, name: "Risk Score" }],
            },
          ],
        };
        myChart.setOption(option);

        function log10(x) {
          return Math.log(x) / Math.log(10);
        }
        function calculateRisk() {
          const productType = parseInt(productTypeEl.value);
          const Sd = parseFloat(SdEl.value);
          const tp = parseFloat(tpEl.value);
          const Ap = parseFloat(ApEl.value);
          const t = parseFloat(tEl.value);
          const Vc = parseFloat(VcEl.value);
          const Fm = parseFloat(FmEl.value);
          const ID = parseFloat(IDEl.value);
          let risk;

          // 计算总风险值
          if (productType === 1) {
            const tmp = Math.pow(Ap,t/tp);
            risk = log10(Vc*Fm/100*Sd+1)/log10(ID+1)/(log10(tmp)+1)*100;
          }else if (productType === 2) {
            const tmp = Math.pow(Ap,t/tp);
            risk = log10(Vc*Fm/100*Sd+1)/log10(ID+1)*100;
          }else {
            const tmp = Math.pow(Ap,t/tp);
            risk = log10(Vc*Fm/100*Sd+1)/log10(ID+1)*(log10(tmp)+1)*100;
          }
          risk = Math.min(Math.max(risk, 0), 100).toFixed(2);
          // 更新图表
          myChart.setOption({
            series: [
              {
                data: [{ value: Math.min(Math.max(risk, 0), 100), name: "Risk Score" }],
              },
            ],
          });
        }

        // 为表单元素绑定事件
        const inputs = document.querySelectorAll("input, select");
        inputs.forEach((input) => {
          input.addEventListener("input", calculateRisk);
        });

        // 初始计算
        calculateRisk();
      });
    </script>

  </body>

</html>