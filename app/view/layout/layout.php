<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->siteTitle(); ?></title>
    <!-- bootstrap 4 -->
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <?= $this->content('head'); ?>
</head>

<body>
    <div class="container">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="<?= url('/', [12, 454]); ?>">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= url('aboutus', [12, 454]); ?>">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
        </ul>
        <br>
        <?= $this->content('body'); ?>
    </div>
    <!-- <script src="<?= asset('js/bootstrap.min.js'); ?>"></script> -->
    <script src="<?= asset('js/jquery-3.4.1.slim.min.js') ?>"></script>
</body>

</html>