<nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow sticky-top">
    <!-- Brand -->
    <a class="navbar-brand m-auto" href="/">X -- cars </a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon fa  fa-bars"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">

            <li class="nav-item">
                <a class="nav-link" href="/brand">Brands</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/brand/models">Models</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/post">Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <?php if (isset($this->session->u) && $this->session->u->type > 2 ){ ?>
            <li class="nav-item dropdown">
                <a  class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"> cpanel
                    <span class="caret fa fa-arrow-down"></span></a>
                <ul class="dropdown-menu p-4">
                    <li><a href="/admincars"> Brands </a></li>
                    <li><a href="/Adminmodels"> Models </a></li>
                    <li><a href="/posts"> Models </a></li>
                    <?php if ($this->session->u->type == 4) {?>
                    <li><a href="#">Users</a></li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="">
        <ul class="navbar-nav">
            <?php if (isset($this->session->u)){ ?>
            <li class="nav-item dropdown ml-auto"><a id="userInfo" href="" data-toggle="dropdown"
                                                     aria-haspopup="true" aria-expanded="false"
                                                     class="nav-link dropdown-toggle"><img
                            src="/public/img/difficulty2.png" alt="Jason Doe" style="max-width: 2.5rem;"
                            class="img-fluid rounded-circle shadow"></a>
                <div aria-labelledby="userInfo" class="dropdown-menu position-absolute" ><a href="#" class="dropdown-item"><strong
                                class="d-block text-uppercase headings-font-family">Mark Stephen</strong><small>Web
                            Developer</small></a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">Settings</a><a href="#" class="dropdown-item">Activity log </a>
                    <div class="dropdown-divider"></div>
                    <a href="/auth/logout" class="dropdown-item">Logout</a>
                </div>
            </li>
            <?php }else{ ?>
                <li class="nav-item">
                    <a class="nav-link" href="/auth">login</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>

<?php $messages = $this->messenger->getMessages();
if (!empty($messages)): foreach ($messages as $message): ?>
    <p class="message <?= $message[1] ?>"><?= $message[0] ?><a href="" class="closeBtn"><i class="fa fa-times"></i></a>
    </p>
<?php endforeach;endif; ?>



