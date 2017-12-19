<?php
/**
 * Created by PhpStorm.
 * User: SMITDOSHI
 * Date: 12/18/17
 * Time: 7:52 PM
 */

?>


<!DOCTYPE html>
<!--[if IE 8 ]><html class="no-js oldie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js oldie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->

    <head>

        <!--- basic page needs
       ================================================== -->
        <meta charset="utf-8">
        <title>Web Post</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- mobile specific metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!--- Meta tag to referesh the page every 2 seconds-->
        <!--    ================================================== -->
        <!--    <meta http-equiv="refresh", content="2">-->

        <!--- Linking Bootstrap
       ================================================== -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


    </head>
    <body>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <?php
                include "test.php";
                foreach ($jsondecodedData['book'] as $bk){

                    $title = !empty($bk['title']) ? $bk['title'] : 'Title is Empty';
                    $body = !empty($bk['body']) ? $bk['body'] : 'Body is Empty';
                    $status = !empty($bk['status']) ? $bk['status'] : 'Status is Empty';
                    $art = new Article();

                    $art->setTitle($title);
                    $art->setBody($body);
                    $art->setStatus($status);

                    if(!empty($bk['author']['email'])) {
                        $name = !empty($bk['author']['name']) ? $bk['author']['name'] : '';
                        $art->setAuthor(new Author($bk['author']['email'], $name));
                    }

                    $art->validate();
                    $errors = $art->getErrors();
                    if(empty($errors)) {
                        $auth = $art->getAuthor();

                        echo "
                        <!-- Post Content Column -->
                        <div class=\"col-lg-12\">
                            <!-- Title -->
                            <h1 class=\"mt-4\">$title</h1>
                            
                            <!-- Author -->
                            <p class=\"lead\">
                                by
                                <a href=\"#\">";

                                        if(empty($errors['author'])){
                                            echo $auth->getAuthorName().' ('.$auth->getAuthorEmail().')';
                                        }

                                echo "</a>
                            </p>
                            
                            <hr>
                            
                                <p>$status</p>
                            
                            <hr>
                            
                            <!-- Post Content -->
                            <p class=\"lead\">$body</p>
                            
                            <hr>

                        </div>
                        ";
                    }else{
                        foreach ($art->getErrors() as $err => $message){
                            echo "<b>".$err.' :</b>'.$message.'<br/><hr>';
                        }
                    }
                }
            ?>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white pull-left">Copyright &copy; Smit</p>
        </div>
        <!-- /.container -->
    </footer>

    </body>
</html>