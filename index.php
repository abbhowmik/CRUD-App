<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "crud";
$conn = mysqli_connect($servername, $username, $password, $database);

$insert = false;
$update = false;
$delete = false;

if(isset($_GET['delete']))
{
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `crud` WHERE `crud`.`slNo`='$sno'";
    $result = mysqli_query($conn, $sql);
    $delete = true;
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if(isset($_POST['snoEdit'])){
    
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['descriptionEdit'];
    
    $sql = "UPDATE `crud` SET `title`='$title', `description`='$description' WHERE `crud`.`slNo`='$sno'";
    $result = mysqli_query($conn, $sql);
    $update = true;
  }

  else{
    $title = $_POST['title'];
    $description = $_POST['desc'];

    $sql = "INSERT INTO `crud` (`title`, `description`) VALUES ('$title','$description')";
    $result = mysqli_query($conn, $sql);
    $insert = true;
     
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <title>CRUD Application</title>
    <!-- <style>
    .entries {
        animation: movedown 1s linear 1;
        animation-delay: 1s;
    }

    @keyframes movedown {
        0% {
            transform: translateX(-100px);
        }

        100% {
            transform: translateX(0);
        }
    }
    </style> -->


</head>

<body>

    <!-- EditModal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/Crud/index.php?" method="post">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <h2>Edit your Notes</h2>
                        <div class="mb-3">
                            <label for="title" class="form-label">Notes Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" />
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label">Notes Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Notes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Navbar-->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CRUD Application</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/Crud">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search or Type Url"
                        aria-label="Search" />
                    <button class="btn btn-warning" type="submit">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <?php
      if($insert)
     {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your note has been added successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
      if($update)
     {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Updated successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
     }
      if($delete)
     {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Note deleted successfully!
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
     }
  ?>


<!--container-->
    <div class="container mt-5">
        <form action="/Crud/index.php" method="post">
            <h2>Write your Notes</h2>
            <div class="mb-3">
                <label for="title" class="form-label">Notes Title</label>
                <input type="text" class="form-control" id="title" name="title" />
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Notes Description</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Notes</button>
        </form>
    </div>


    <div class="entries container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  $sql = "SELECT * FROM `crud`";
                  $sno = 0;
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_assoc($result)){
                    $sno = $sno + 1;
                    echo "<tr>
                            <th scope='row'>".$sno. "</th>
                            <td>".$row['title']. "</td>
                            <td>".$row['description']. "</td>
                            <td><button class='edit btn btn-primary mb-2' id=".$row['slNo'].">Edit</button>
                            <button class='delete btn btn-outline-danger' id=d".$row['slNo'].">Delete</button>
                            </td>
                      </tr>";
                    echo "<br>";
                }
              ?>
            </tbody>

        </table>
        <hr>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous">
    </script>


    <!-- importing the jQuery file -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous">
    </script>

    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>

    <!-- writing editing javascript -->
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((Element) => {
        Element.addEventListener("click", (e) => {
            // console.log("edit", );
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            // console.log(title, description);
            titleEdit.value = title;
            descriptionEdit.value = description;
            snoEdit.value = e.target.id;
            // console.log(e.target.id);
            $('#editModal').modal('toggle');
        })
    })


    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((Element) => {
        Element.addEventListener("click", (e) => {
            sno = e.target.id.substr(1, );
            if (confirm("Are you want to delete this note completely")) {
                console.log("Deleted Successully");
                window.location = `/Crud/index.php?delete=${sno}`;
            }
        })
    })
    </script>



</body>

</html>


<!-- data-bs-toggle='modal' data-bs-target='#editModal' -->