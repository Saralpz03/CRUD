<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- BOOTSTRAP 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!--  Si metemos la libreria de jquery 3.6 nos da un error y no nos saca la tabla, debe de ser un error de la version
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
        -->
        <!-- CSS -->
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <main>
            <nav class="cabecera_index">
                BIENVENIDO A ADMIN LIBROS
            </nav>
            <section class="contenido">
                <div class="cabecera_tabla">
                    <a href="" class="btn btn-success add"><i class="bi bi-plus-square-fill "></i>Añadir Libro</a>
                    <form method="post" action="#" id="selected_form">
                        <div id="ajustar_seleccion">
                            <select name="limit-records" id="limit-records" class="form-select text-end">
                                    <option value="5" selected="selected">5</option>
                                    <?php foreach([5,100,500,1000,5000] as $limit): ?>
                                        <option <?php if( isset($_POST["limit-records"]) && $_POST["limit-records"] == $limit) echo "selected" ?> value="<?= $limit; ?>"><?= $limit; ?></option>
                                    <?php endforeach; ?>
                            </select>
                            
                        </div>
                        
                    </form>
                </div>
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th scope="col" class="columna_id">ID</th>
                        <th scope="col" class="columna_titulo">TITULO</th>
                        <th scope="col">AUTOR</th>
                        <th scope="col">CATEGORIA</th>
                        <th scope="col">PORTADA</th>
                        <th scope="col" class="columna_disponibilidad">DISPONIBILIDAD</th>
                        <th scope="col" class="columna_planta">PLANTA</th>
                        <th scope="col" class="columna_seccion">SECCIÓN</th>
                        <th scope="col">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    
                    include "includes/conection.php";
                    $acentos = $conn->query("SET NAMES 'utf8'");

                    $limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 5;
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $start = ($page - 1) * $limit;

                    $query = "SELECT * FROM libros LIMIT $start, $limit";

                    $result1 = $conn->query("SELECT count(id) AS id FROM libros");
                    $custCount = $result1->fetch_all(MYSQLI_ASSOC);
                    $total = $custCount[0]['id']; 
                    $pages = ceil( $total / $limit ); 
                    
                    $Previous = $page - 1;
                    $Next = $page + 1;

                    if ($result = mysqli_query ($conn,$query)){
                        while($fila = mysqli_fetch_array($result)){
                            echo'
                            <tr>
                            <th scope="row">'.$fila["id"].'</th>
                            <td>'.$fila["titulo"].'</td>
                            <td>'.$fila["autor"].'</td>
                            <td>'.$fila["categoria"].'</td>
                            <td>'.$fila["portada"].'</td>
                            <td>'.$fila["disponibilidad"].'</td>
                            <td>'.$fila["planta"].'</td>
                            <td>'.$fila["seccion"].'</td>
                            <td>
                              <a href="" class="btn btn-warning"><i class="bi bi-pencil-square"></i></i></a>
                              <a href="" class="btn btn-danger"><i class="bi bi-x-circle-fill"></i></a>
                              <a href="" class="btn btn-success"><i class="bi bi-box-arrow-up-right"></i></a>
                            </td>
                          </tr>
                            ';
                        }
                    }
                    ?>
                  </tbody>
                </table>
                <nav aria-label="Page navigation example" class="nav-paginas">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="index.php?page=<?= $Previous; ?>">Previous</a></li>
                        <?php for($i = 1; $i<= $pages; $i++) :
                            if ($i==$page) {
                                $li_active="class='page-item'";
                                $active = "class='active page-link'"; 
                            }else {
                                $li_active="class='page-item'";
                                $active = "class='page-link'"; }
                        ?>
                            <li <?php echo $li_active; ?>><a href="index.php?page=<?= $i; ?>" <?php echo $active; ?>><?= $i; ?></a></li>
                        <?php endfor; ?> 
                        <li class="page-item"><a class="page-link" href="index.php?page=<?= $Next; ?>">Next</a></li>
                    </ul>
                </nav>
            </section>
        </main>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#limit-records").change(function(){
                    $('form').submit();
                })
            })
        </script>
    </body>
</html>