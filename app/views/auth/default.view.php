<style>
    .sin-in , .log-message{
        display: none;
    }
</style>
<div class="page-holder d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-5 col-lg-7 mx-auto mb-5 mb-lg-0">
                <div class="pr-lg-5"><img src="/public/img/illustration.svg" alt="" class="img-fluid"></div>
            </div>
            <div class="col-lg-5 px-lg-4">
                <h1 class="text-base text-primary text-uppercase mb-4"> <span class="log-in">Log in</span> <span class="sin-in">Register </span> to X-cars</h1>
                <h2 class="mb-4">Welcome back! </h2>
                <p class="mb-2 log-message ">  </p>
                <form id="loginForm" action="/auth" method="post" class="mt-4 log-form log-in">
                    <div class="form-group mb-4">
                        <input type="text" name="username" placeholder="Username or Email address" class="form-control border-0 shadow form-control-lg">
                    </div>
                    <div class="form-group mb-4">
                        <input type="password" name="passoword" placeholder="Password" class="form-control border-0 shadow form-control-lg text-violet">
                    </div>
                    <button type="submit" class="btn btn-primary shadow px-5">Sin in</button>
                    or   <button  class="btn btn-primary shadow px-5 toglle-form">Create new account </button>
                </form>
                <form id="registerForm" action="/auth/register" method="post" class="mt-4 log-form sin-in">
                    <div class="form-group mb-4">
                        <input type="text" name="username" required placeholder="Username  " class="form-control border-0 shadow form-control-lg">
                    </div>

                    <div class="form-group mb-4">
                        <input type="email" name="email" required placeholder="Email address  " class="form-control border-0 shadow form-control-lg">
                    </div>
                    <div class="form-group mb-4">
                        <input type="number" name="phone" required placeholder="Phone Number  " class="form-control border-0 shadow form-control-lg">
                    </div>
                    <div class="form-group mb-4">
                        <textarea rows="5" name="bio" required placeholder=" bio " class="form-control border-0 shadow form-control-lg"></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <input type="password" name="password" required placeholder="Password" class="form-control border-0 shadow form-control-lg text-violet">
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input id="customCheck1" type="radio" required name="type" value="1" class="custom-control-input">
                        <label for="customCheck1" class="custom-control-label">my account is personal .</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input id="customCheck2" required type="radio" name="type" value="2" class="custom-control-input">
                        <label for="customCheck2" class="custom-control-label"> my account for campany .</label>
                    </div>
                    <button type="submit" class="btn btn-primary shadow px-5">Sin up Now</button>
                    or   <button  class="btn btn-primary shadow px-5 toglle-form"> You have a account </button>
                </form>


            </div>
        </div>
    </div>
</div>

