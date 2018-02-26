<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 26-02-2018
 * Time: 23:09
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>PHP-Paypal Integration</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel='stylesheet prefetch' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>

    <script src="//code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="//unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="/assets/css/style.css">
    <script type="text/javascript" src="/assets/js/main.js"></script>
</head>
<body>
<div class="container">
    <div class="container-fluid">
        <div class="centered title"><h1>PHP-Paypal Integration</h1></div>
    </div>
</div>
<hr class="featurette-divider">
<div class="container">
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="/makepayment" method="post" autocomplete="off">
                    <div class="form-row">
                        <div class="form-group required">
                            <?php if (isset($_SESSION['error'])): ?>
                            <div class="error form-group">
                                <div class="alert-danger alert">
                                    <?php echo $_SESSION['error']; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <label class="control-label">First name</label>
                            <input type="text" class="form-control" name="first_name" placeholder="First Name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group card required">
                            <label class="control-label">Last name</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group card required">
                            <label class="control-label">Email ID</label>
                            <input type="email" class="form-control" name="email" placeholder="name@example.com">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group card required">
                            <label class="control-label">Mobile number <b>+91 </b></label>
                            <input type="text" class="form-control" name="mobile" placeholder="91xxxxxx">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group cvc required">
                            <label class="control-label">Amount <b>$. </b></label>
                            <input type="text" class="form-control" name="amount" placeholder="100.00">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="control-label"></label>
                            <input type="hidden" name="item_name" value="Test Item">
                            <input type="hidden" name="item_number" value="123456">
                            <button class="form-control btn btn-primary" type="submit"> Continue →</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
