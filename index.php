<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website quản lý ở nội trú ký túc xá</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" />
    <link rel="shortcut icon" href="https://juniv.edu/images/favicon.ico">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="../img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="home.css" />
</head>

<body>
    <header class="header">
        <img src="images/hust_logo.png" alt style="height: 70px; width: 65px">
        <a href="#" class="logo" style="text-decoration: none;">HỆ THỐNG QUẢN LÝ KÝ TÚC XÁ</a>
        <nav class="navbar">
            <a href="#about" style=" text-decoration:none; ">Giới thiệu</a>
            <a href="#provost" style=" text-decoration:none; ">Thông báo</a>
            <a href="#hall" style=" text-decoration:none; ">Tòa nhà</a>
            <a href="#Gallery" style=" text-decoration:none; ">Gallery</a>

            <a href="#contact" style=" text-decoration:none; ">Liên hệ</a>
            <button id="admin" style="    margin-left: 7px;height: 80px;width: 80px"><a href="login.php"
                    style=" text-decoration:none; text-align:centre" id="link1">Đăng nhập</a></button>
        </nav>

        </nav>
        <!----Login form---->
        <div class="modal fade" id="loginModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title w-100">
                            <h4 class="text-muted">Login To Your Accout</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body ">
                        <form action="" class="was-validated">
                            <div class="form-group">
                                <label for="email" class="text-info font-weight-bold">Email:</label>
                                <input type="email" class="form-control" placeholder="Enter Your Email" required>
                                <div class="valid-feedback">
                                    <strong>Your email address is valid</strong>
                                </div>
                                <div class="invalid-feedback">
                                    <strong>Please Enter a valid email address</strong>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pwd" class="text-primary font-weight-bold">Password:</label>
                                <input type="password" class="form-control" placeholder="Enter Your Password"
                                    minlength="6" maxlength="8" required>
                                <div class="valid-feedback">
                                    <strong>Your password very strong</strong>
                                </div>
                                <div class="invalid-feedback">
                                    <strong>Enter your password first</strong>
                                </div>
                            </div>
                            <div class="form-group form-group-check">
                                <label for="chk" class="form-group-label text-light font-weight-bold">
                                    <input type="checkbox" class="form-group-input"> Remember Me
                                </label>
                            </div>
                            <input type="submit" class="form-control btn btn-outline-success font-weight-bold"
                                value="LogIn">
                        </form>
                    </div> <!----modal body close--->
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div> <!----modal content close--->
            </div> <!----modal dialog close--->
        </div> <!----modal close--->




        </nav>
    </header>
    <!-- header end -->

    <!-- main slide -->
    <div id="pslide" class="carousel slide" data-ride="carousel" style="margin-left: 40px; margin-right:40px">

        <!-- slider -->

        <div class="carousel-inner" data-interval="500">
            <!-- 1st slider -->
            <div class="carousel-item active">
                <!-- slider caption -->
                <div class="carousel-caption d-none d-md-block">
                    <!--   <h2 class="display-1 text-danger">This is my first slider</h2> -->
                </div>
                <img src="images/1.png" height="600px" width="100%" alt="">
            </div>
            <!-- 2nd slider -->
            <div class="carousel-item">
                <!-- slider caption -->
                <div class="carousel-caption">
                    <!--  <h2 class="display-1">This is my second slider</h2> -->
                </div>
                <img src="images/h1.jpg" height="600px" width="100%" alt="">
            </div>
            <!-- 3rd slider -->
            <div class="carousel-item">
                <!-- slider caption -->
                <div class="carousel-caption">
                    <!--   <h2 class="display-1">This is my third slider</h2> -->
                </div>
                <img src="images/h9.jpg" height="600px" width="100%" alt="">
            </div>
            <!-- 4th slider -->
            <div class="carousel-item">
                <!-- slider caption -->
                <div class="carousel-caption">
                    <!--    <h2 class="display-1">This is my third slider</h2> -->
                </div>
                <img src="images/2.jpg" height="600px" width="100%" alt="">
            </div>
        </div>

        <!-- next and prev icon -->
        <a href="#pslide" class="carousel-control-prev" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a href="#pslide" class="carousel-control-next" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
    <!-- slider end -->
</body>

</html>