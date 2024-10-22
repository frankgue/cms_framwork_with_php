<?php
 require_once "includes/header_admin.php"; 
 require_once "includes/bdd.php"; 
 require_once "fonctions.php"; 
?>

<?php

    //Save Categorie
    if (isset($_POST['enregistrer_categorie'])) {
        enregistrer_categorie();
    }
    
    //Delete categorie
    if(isset($_GET['supprimer'])){       
        supprimer_categorie();
    }
    

?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once "includes/sidebar_left_admin.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require_once "includes/topbar_admin.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Catégories</h1>

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <?php 
                                        if (isset($message)) {
                                           echo $message;
                                        }
                                    ?>
                                        <h3 class="text-center font-weight-light my-4">Nouvelle Catégorie</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="form-floating mb-3">
                                                <label for="inputNomCategorie">Nom Catégorie</label>
                                                <input class="form-control" id="inputNomCategorie" type="text"
                                                    name="nom_categorie" />
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <input type="submit" value="Enregistrer" name="enregistrer_categorie"
                                                    class="btn btn-primary" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                    
                    if(isset($_GET['modifier'])){
                        //Modification d'une categorie
                        recuperer_categorie_modif();
                        
                        //Update Categories
                        if (isset($_POST['modifier_categorie'])) {
                         modifier_categorie();
                        }
                        
                        ?>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <?php 
                                        if (isset($message3)) {
                                           echo $message3;
                                        }
                                    ?>
                                        <h3 class="text-center font-weight-light my-4">Modifier Catégorie</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="form-floating mb-3">
                                                <label for="inputNomCategorie">Nom Catégorie</label>
                                                <input class="form-control" id="inputNomCategorie" type="text"
                                                    value="<?= $data['nom_categorie'] ?>" name="nom_categorie_modif" />

                                                <input type="hidden" name="id_categorie_modif"
                                                    value="<?= $id_categorie_modif ?>">
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <input type="submit" value="Modifier" name="modifier_categorie"
                                                    class="btn btn-primary" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br><br>
                    <?php
                    
                    }
                    
                    ?>

                    <br><br><br>
                    <?php
                        if (isset($message2)) {
                            echo "<center style='color:blue'>".$message2."</center><br/><br/>";
                        }
                    ?>

                    <!-- DataTales  -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Catégories</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>s
                                                    <th>Nom de la catégorie</th>
                                                    <th>Supprimer</th>
                                                    <th>Modifier</th>
                                                </tr>
                                            </thead>
                                            <!-- <tfoot>
                                                <tr>
                                                    <th>Nom de la catégorie</th>
                                                    <th>Supprimer</th>
                                                </tr>
                                            </tfoot> -->
                                            <tbody>

                                                <?php
                                                afficher_categories();
                                            ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php   require_once "includes/footer_admin.php";   ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php   require_once "includes/mode_deconnexion.php";   ?>


    <!-- Bootstrap core JavaScript-->
    <?php   require_once "includes/bootstrap_js.php";   ?>

</body>

</html>