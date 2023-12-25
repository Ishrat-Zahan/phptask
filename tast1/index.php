<?php
require 'dbConnection/db.php';
$users = "select * from users where 1";
$user = $conn->query($users);

$products = "select * from products where 1";
$product = $conn->query($products);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>

    <link rel="stylesheet" href="assets/bootstrap.min.css">

</head>

<body>

    <div class="container">
        <div class="row">

            <div class="col-6">

                <h1>Create Review:</h1>
                <form class="mt-4" id="reviewForm">
                    <label class="form-label" for="user_id">User ID:</label>

                    <select required id="user_id" name="user_id" class="form-select">
                        <option value="">Select User</option>

                        <?php while ($row = $user->fetch_assoc()) { ?>

                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>

                        <?php } ?>

                    </select>
                    <br>

                    <label class="form-label" for="product_id">Product ID:</label>

                    <select class="form-select" id="product_id" name="product_id" required>
                        <option value="">Select Product</option>

                        <?php while ($row = $product->fetch_assoc()) { ?>

                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>

                        <?php } ?>

                    </select>
                    <br>

                    <label class="form-label" for="review_text">Review Text:</label>
                    <textarea class="form-control" id="review_text" name="review_text" required></textarea><br>

                    <button class="btn btn-primary" type="button" onclick="createReview()">Submit Review</button>
                </form>

                <div class="text-danger" id="error"></div>


            </div>


            <div class="col-6">

                <h1>Reviews:</h1>
                <table class="table table-striped table-hover mt-4">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">User</th>
                            <th scope="col">Product</th>
                            <th scope="col">Review</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $sql = "
                            SELECT 
                                users.id AS user_id, 
                                users.name AS user_name, 
                                products.id AS product_id,
                                products.name AS product_name, 
                                review.review_text AS review_text 
                            FROM 
                                review 
                            LEFT JOIN 
                                products ON review.product_id = products.id 
                            LEFT JOIN 
                                users ON review.user_id = users.id
                            ";


                        $result = $conn->query($sql);
                        if ($result) {
                            $counter = 1;

                            while ($row = $result->fetch_assoc()) {
                                $user_id = $row['user_id'];
                                $user = $row['user_name'];
                                $product = $row['product_name'];
                                $review = $row['review_text'];

                                echo '<tr>
                                <th scope="row">' . $counter . '</th>
                                <td>' . $user . '</td>
                                <td>' . $product . '</td>
                                <td>' . $review . '</td>                                   
                             </tr>';

                                $counter++;
                            }
                        }


                        $conn->close();

                        ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <script src="assets/jquery-3.6.3.min.js"></script>
    <script src="assets/bootstrap.bundle.min.js"></script>


    <script>

        function createReview() {

            var user_id = $('#user_id').val();
            var product_id = $('#product_id').val();
            var review_text = $('#review_text').val();

            $.ajax({

                type: 'POST',
                url: 'http://localhost/projectFolder/endpoint.php',
                data: JSON.stringify({

                    user_id: user_id,
                    product_id: product_id,
                    review_text: review_text

                }),

                contentType: 'application/json',
                success: function(response) {
                   
                    if (response.message) {
                        alert(response.message);
                        location.reload();
                    } else {
                        $("#error").text(response.error);
                    }

                },
                error: function() {
                   
                    $("#error").text("Error occurred during the request.");
                }
            });

        }

    </script>


</body>

</html>