<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img class="img-fluid img-thumbnail"src="/public/img/q.png">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-icon"></span>
            <span class="navbar-icon"></span>
            <span class="navbar-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

<?php if (isset($this->session->u)){ ?>

                <?php
if ($this->session->u->TYPE_ID == 1 ){?>


    <li class="nav-item">
        <a class="nav-link <?= $title == "courses" ? 'active' :'' ?> " href="/Course">Courses</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $title == "exams" ? 'active' :'' ?>" href="/exam/">Exams</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/index/contact">CONTACT US</a>
    </li>
    <li class="dropdown navbar-light navbar-nav nav-item <?= $title == "Admin-courses" || $title == "students" ||
    $title == "instructor"  ? 'active'
        :'' ?>">
        <button type="button" class="dropdown-toggle" style="color: #FFF;"  data-toggle="dropdown">
            Admin
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/admin/courses">Coueses </a>
            <a class="dropdown-item" href="/admin/students">Students </a>
            <a class="dropdown-item" href="/admin/instructors" >instructors </a>
        </div>
    </li>

<?php }elseif ($this->session->u->TYPE_ID == 2 ){?>

	
    <li class="nav-item">
        <a class="nav-link <?= $title == "courses" ? 'active' :'' ?> " href="/Course">Courses</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?= $title == "exams" ? 'active' :'' ?>" href="/exam/">Exams</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/index/contact">CONTACT US</a>
    </li>
<?php } else{ ?>

<li class="nav-item">
        <a class="nav-link" href="/exam/student">exam<span class="sr-only">(current)</span></a>
    </li>
<?php }?>
    <li class="dropdown navbar-light navbar-nav nav-item  <?= $title == "setting"? 'active'  : '' ?>">
        <button type="button" class=dropdown-toggle" style="color: #FFF;" data-toggle="dropdown">
            <?= $this->session->u->USER_NAME ?> <i class=""></i>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/editprofile">Settings</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/auth/logout">logout </a>
        </div>
    </li>



<?php }else{ ?>
    <li class="nav-item">
        <a class="nav-link" href="/">HOME<span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/index/about">ABOUT US</a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/auth/register">Register</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/auth">Login</a>
    </li>

<?php }?>
            </ul>
        </div>
    </div>
</nav>
      -->


<style>
.carousel-item img {
    width:100%;
}
.carousel-caption .baground{
    background-color: #373738;
    opacity: 0.5;
    position: absolute;
    height: 100%;
    width: 100%;
    z-index: 11;
}
.carousel-caption .text{
    z-index: 12;
    color: white !import;
    position: sticky;
}

</style>