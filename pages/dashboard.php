<?php
session_start();
if (!isset($_SESSION['email'])) { //if login in session is not set
  header("location: sign-in.html");
}
include_once('./includes/api.inc.php');
include_once('./includes/dbh.inc.php');
include_once('./includes/cryptofunctions.inc.php');
$holdings = get_holdings($conn, $_SESSION['id']);
$crypto_info = coingGeckoRequest();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/logo-main.png" />
  <title>Ember</title>
  <!--     Fonts and icons     -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="http://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Bootstrap -->
  <link rel="stylesheet" href="http://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.4" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/charts.css" rel="stylesheet" />
  <!-- Chart.js -->
  <script src="../assets/js/plugins/chart.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">

<?php include_once("aside.php") ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">

      <div class="container-fluid py-1 px-3">

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-4 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here..." />
            </div>
          </div>
          <ul class="navbar-nav justify-content-end">

            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><?php echo $_SESSION["first_name"]; ?></span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>

              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3" />
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span>
                          from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark me-3" />
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by
                          Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="avatar avatar-sm bg-gradient-secondary me-3 my-auto">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                              <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                  <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                  <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          2 days
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <?php include_once('header.php') ?>
    


    <div class="row my-4">
      <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
        <div class="card">

          <div class="card-body py-1 px-1 pb-2 md-pt-1">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-primary text-sm font-weight-bolder opacity-7" style="border-top-width: 0px !important;">
                      Coin
                    </th>
                    <th class="text-uppercase text-primary text-sm font-weight-bolder opacity-7 ps-2" style="border-top-width: 0px !important;">
                      24 Hour Change
                    </th>
                    <th class="text-center text-uppercase text-primary text-sm font-weight-bolder opacity-7" style="border-top-width: 0px !important;">
                      Price in USD
                    </th>
                    <th class="text-center text-uppercase text-primary text-sm font-weight-bolder opacity-7" style="border-top-width: 0px !important;">
                      Market Cap
                    </th>
                    <th class="text-center text-uppercase text-primary text-sm font-weight-bolder opacity-7" style="border-top-width: 0px !important;">

                    </th>

                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="border-width: 0px !important;">
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="http://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/128/icon/btc.png" class="avatar avatar-sm me-3" alt="xd" />
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">Bitcoin</h6>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle text-center text-sm" style="border-width: 0px !important;">
                      <span class="text-sm font-weight-bold">
                        <?php echo roundDecimal($crypto_info[0]->price_change_percentage_24h_in_currency); ?>%
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm" style="border-width: 0px !important;">
                      <span class="text-sm font-weight-bold">
                        $<?php echo number_format($crypto_info[0]->current_price); ?>
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm" style="border-width: 0px !important;">
                      <span class="text-sm font-weight-bold">
                        $<?php echo number_format($crypto_info[0]->market_cap); ?>
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm" style="border-width: 0px !important;">
                      <span class="text-sm font-weight-bold">
                        <a class="btn btn-outline-dark w-100 p-1 mt-3" href="coin.php?c=bitcoin">Trade</a>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td style="border-width: 0px !important;">
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="http://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/128/icon/eth.png" class="avatar avatar-sm me-3" alt="atlassian" />
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">Ethereum</h6>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle text-center" style="border-width: 0px !important;">
                      <span class="text-sm font-weight-bold">
                        <?php echo roundDecimal($crypto_info[1]->price_change_percentage_24h_in_currency); ?>%
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm" style="border-width: 0px !important;">
                      <span class="text-sm font-weight-bold">
                        $<?php echo number_format($crypto_info[1]->current_price); ?>
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm" style="border-width: 0px !important;">
                      <span class="text-sm font-weight-bold">
                        $<?php echo number_format($crypto_info[1]->market_cap); ?>
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm" style="border-width: 0px !important;">
                      <span class="text-sm font-weight-bold">
                        <a class="btn btn-outline-dark w-100 p-1 mt-3" href="coin.php?c=ethereum">Trade</a>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="http://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/128/icon/doge.png" class="avatar avatar-sm me-3" alt="team7" />
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">Dogecoin</h6>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-sm font-weight-bold">
                        <?php echo roundDecimal($crypto_info[2]->price_change_percentage_24h_in_currency); ?>%
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-sm font-weight-bold">
                        $<?php echo roundDecimal($crypto_info[2]->current_price, 4); ?>
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <span class="text-sm font-weight-bold">
                        $<?php echo number_format($crypto_info[2]->market_cap); ?>
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm" style="border-width: 0px !important;">
                      <span class="text-sm font-weight-bold">
                        <a class="btn btn-outline-dark w-100 p-1 mt-3" href="coin.php?c=dogecoin">Trade</a>
                      </span>
                    </td>
                  </tr>



                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <?php
        $orders = fetchRecentOrders($conn, $_SESSION["id"], 10);
        ?>
        <div class="card h-100">
          <div class="card-header pb-0">
            <h6>History</h6>
            <p class="text-sm">
              <!-- <i class="fa fa-arrow-up text-success" aria-hidden="true"></i> -->
              Your last <span class="font-weight-bold"><?php echo count($orders); ?></span> trades
            </p>
          </div>
          <div class="card-body p-3">
            <div class="timeline timeline-one-side">
              <?php


              foreach ($orders as $order) {
                $type;
                $price;
                if (intval($order["rec_id"]) == intval($_SESSION["id"])) {
                  $type = "Bought";
                  $price = $order["buy_price"];
                } else {
                  $type = "Sold";
                  $price = $order["sell_price"];
                }
                echo '<div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <img src="http://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/128/icon/' . $order["coin"] . '.png" class="avatar avatar-sm me-1" alt="xd" />
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">
                        ' . $type . ' ' . $order["amount"] . ' ' . $order["coin"] . ' at $' . number_format($price, 2) . '
                      </h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                        ' . time2str($order["date_time"]) . '
                      </p>
                    </div>
                  </div>';
              }
              ?>
              


            </div>
          </div>
        </div>
      </div>
    </div>
    <?php 
              include_once("news.php");
              ?>
    <footer class="footer pt-3">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              ©
              <script>
                document.write(new Date().getFullYear());
              </script>
              Ember
              </div>
                </div>
                  </div>
                    </div>
                      </footer>
                        </div>
                          </main>

                            <!--Core JS Files-->
                              <script src="../assets/js/core/popper.min.js">
                              </script>
                              <script src="../assets/js/core/bootstrap.min.js"></script>
                              <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
                              <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
                              <script src="../assets/js/plugins/chartjs.min.js"></script>
                              <!-- Github buttons -->
                              <script async defer src="http://buttons.github.io/buttons.js"></script>
                              <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
                              <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.4"></script>
                              <script src="http://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                              <script src="http://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                              <script src="http://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
                              <script src="../assets/js/plugins/countup.js"></script>
</body>

</html>