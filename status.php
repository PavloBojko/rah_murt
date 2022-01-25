<?php
session_start();
require 'functions.php';
if (!or_an_auth_user()) {
    go_to_page('page_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
        <a class="navbar-brand d-flex align-items-center fw-500" href="users.html"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Главная <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="page_login.html">Войти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>
    <main id="js-page-content" role="main" class="page-content mt-3">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-sun'></i> Установить статус
            </h1>

        </div>
        <?php
        $id = $_GET['id'];
        $result = get_user_on_id($id);
        $email = $result['email'];
        $status_user = get_status($result['status']);
        $name_status_user = $status_user[0]['name_status'];
        $result = get_status();
        ?>
        <?php
        if (!user_is_admin_in_Sesion()) {
            if ($_SESSION['user'] != $result['email']) {
                set_type_messege('danger', 'Можно редактировать только свой профиль');
                go_to_page('users.php');
                exit;
            }
        }
        ?>
        <form action="edit_status.php" method="POST">
            <div class="row">
                <div class="col-xl-6">
                    <div id="panel-1" class="panel">
                        <div class="panel-container">
                            <div class="panel-hdr">
                                <h2>Установка текущего статуса</h2>
                            </div>
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- status -->
                                        <div class="form-group">
                                            <label class="form-label" for="example-select">Выберите статус</label>
                                            <select class="form-control" id="example-select" name="status">
                                                <?php
                                                foreach ($result as $key => $value) {
                                                ?>
                                                    <option value="<?php echo $value['id'] ?>" <?php echo $value['name_status']==$name_status_user ? 'selected':'' ?> ><?php echo $value['name_status'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" value=<?php echo $id ?> name="id">
                                    <input type="hidden" value=<?php echo $email ?> name="email">

                                    <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                        <button class="btn btn-warning" type="submit" name="stts">Set Status</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>
        $(document).ready(function() {

            $('input[type=radio][name=contactview]').change(function() {
                if (this.value == 'grid') {
                    $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                    $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                    $('#js-contacts .js-expand-btn').addClass('d-none');
                    $('#js-contacts .card-body + .card-body').addClass('show');

                } else if (this.value == 'table') {
                    $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                    $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                    $('#js-contacts .js-expand-btn').removeClass('d-none');
                    $('#js-contacts .card-body + .card-body').removeClass('show');
                }

            });

            //initialize filter
            initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });
    </script>
</body>

</html>