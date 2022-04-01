<?php 

$priceUrl="https://api.coingecko.com/api/v3/simple/price?ids=bitcoin%2Cethereum%2Cdogecoin&vs_currencies=usd";

$result = file_get_contents($priceUrl);
$resultInfo = json_decode($result, true);
?>

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">
                      Total Holdings
                    </p>
                    <h5 class="font-weight-bolder mb-0">

                      $<?php
                      echo number_format(array_sum([$resultInfo["bitcoin"]["usd"]*get_holdings($conn, intval($_SESSION["id"]))["btc"], $resultInfo["ethereum"]["usd"]*get_holdings($conn, intval($_SESSION["id"]))["eth"], $resultInfo["dogecoin"]["usd"]*get_holdings($conn, intval($_SESSION["id"]))["doge"]]));
                      ?> USD
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">
                      BTC
                    </p>
                    <h5 class="font-weight-bolder mb-0">
                      <?php
                      echo get_holdings($conn, intval($_SESSION["id"]))["btc"];
                      ?>
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <img href="coin.php?c=bitcoin" src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/128/icon/btc.png" class="avatar avatar-m " alt="xd" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">
                      ETH
                    </p>
                    <h5 class="font-weight-bolder mb-0">
                      <?php
                      echo get_holdings($conn, intval($_SESSION["id"]))["eth"];
                      ?>
                      <span class="text-danger text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <img src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/128/icon/eth.png" class="avatar avatar-m " alt="xd" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">
                      DOGE
                    </p>
                    <h5 class="font-weight-bolder mb-0">
                      <?php
                      echo get_holdings($conn, intval($_SESSION["id"]))["doge"];
                      ?>
                      <span class="text-success text-sm font-weight-bolder"></span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <img src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/128/icon/doge.png" class="avatar avatar-m " alt="xd" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>