<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Big-grow Coin Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/coin.css">
    <style>
        body {
            background: radial-gradient(circle at top, #3a0ca3, #0b061a);
            color: #fff;
            font-family: system-ui, -apple-system, BlinkMacSystemFont;
        }

        /* Glass Cards */
        .glass {
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 18px;
        }

        /* Buttons */
        .btn-purple {
            background: linear-gradient(135deg, #9d4edd, #c77dff);
            border: none;
            color: #fff;
            box-shadow: 0 0 20px rgba(199, 125, 255, .6);
        }

        .btn-purple:hover {
            opacity: .9;
        }

        .btn-outline-purple {
            border: 1px solid #c77dff;
            color: #c77dff;
        }

        .btn-outline-purple:hover {
            background: #c77dff;
            color: #000;
        }

        /* Badge */
        .badge-purple {
            background: linear-gradient(90deg, #c77dff, #9d4edd);
            color: #000;
        }

         /* Counters */
        .counter {
            font-size: 1.8rem;
            font-weight: 700;
            color: #e0aaff;
        }
    </style>
</head>

<body>
    <div class="container py-4 py-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                <span class="badge badge-purple">Biggrow Coin Chain</span>
                <h1 class="fw-bold mt-3 fs-2 fs-md-1">
                    A Smarter Way<br>
                    <span class="text-warning">To Grow Coins</span>
                </h1>

                <p class="opacity-75 mt-3">
                    A biggrow-powered coin ecosystem where every buy and sell
                    transaction rewards your wallet automatically.
                </p>

                <div class="flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                    <a href="<?php echo USER_LOGIN_LINK; ?>" class="btn btn-purple px-4 py-2">Login</a>
                    <a href="<?php echo USER_SIGNUP_LINK.REGISTER_CODE; ?>" class="btn btn-outline-purple px-4 py-2 w-40">Sign Up</a>
                </div>

                <!-- Counters -->
                <div class="row text-center mt-4">
                    <div class="col-4 col-sm-4 mb-3">
                        <div class="counter" data-target="4">0</div>
                        <small>Bonus %</small>
                    </div>
                    <div class="col-4 col-sm-4 mb-3">
                        <div class="counter" data-target="18000">0</div>
                        <small>Trades</small>
                    </div>
                    <div class="col-4 col-sm-4">
                        <div class="counter" data-target="26000">0</div>
                        <small>Users</small>
                    </div>
                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-6">
                <div class="coin-wrap">
                    <div class="coin"></div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <div class="glass p-3 h-100">
                            <h6 class="text-warning">+4% On Buy</h6>
                            <p class="small opacity-75 mb-0">
                                Buying coins instantly boosts wallet balance.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="glass p-3 h-100">
                            <h6 class="text-warning">+4% On Sell</h6>
                            <p class="small opacity-75 mb-0">
                                Selling coins adds extra reward again.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="glass p-3 h-100">
                            <h6 class="text-warning">Infinite Cycle</h6>
                            <p class="small opacity-75 mb-0">
                                No limits on buy & sell reward chain.
                            </p>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="glass p-3 h-100">
                            <h6 class="text-warning">Live Wallet</h6>
                            <p class="small opacity-75 mb-0">
                                Wallet updates instantly after each trade.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Workflow -->
                <div class="glass p-3 mt-4">
                    <h6 class="text-center text-warning mb-3">Reward Flow</h6>
                    <p class="mb-1">1️⃣ Create account & wallet</p>
                    <p class="mb-1">2️⃣ Buy coins → +4%</p>
                    <p class="mb-1">3️⃣ Hold or sell anytime</p>
                    <p class="mb-1">4️⃣ Sell coins → +4%</p>
                    <p class="mb-0">5️⃣ Repeat endlessly</p>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.querySelectorAll('.counter').forEach(counter => {
            const target = +counter.dataset.target;
            let value = 0;
            const step = target / 90;
            const update = () => {
                value += step;
                if (value < target) {
                    counter.innerText = Math.ceil(value);
                    requestAnimationFrame(update);
                } else {
                    counter.innerText = target;
                }
            };
            update();
        });
    </script>
</body>
</html>