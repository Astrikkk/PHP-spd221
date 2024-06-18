<?php global $dbh; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
</head>
<body>
<?php include $_SERVER["DOCUMENT_ROOT"]."/header.php"; ?>
<?php include $_SERVER["DOCUMENT_ROOT"]."/connection_database.php"; ?>

<div class="container">
    <h1 class="text-center">
        Userlist
    </h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">ПІБ</th>
            <th scope="col">Фото</th>
            <th scope="col">Пошта</th>
            <th scope="col">Телефон</th>
            <th scope="col">Category</th>
            <th scope="col"></th>
            <th scope="col"></th> <!-- New column for delete button -->
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = 'SELECT u.id, u.name, u.image, u.email, u.phone, c.name AS category, u.categories_id
        FROM users u
        LEFT JOIN categories c ON u.categories_id = c.id';

        foreach ($dbh->query($sql) as $row) {
            $id = $row["id"];
            $name = $row["name"];
            $image = $row["image"];
            $email = $row["email"];
            $phone = $row["phone"];
            $category = $row["category"];
            $categoryId = $row["categories_id"]; // Fetch category id

            echo "
    <tr>
        <th scope='row'>$id</th>
        <td>$name</td>
        <td>
            <img src='$image' alt='$name' width='150'>
        </td>
        <td>$email</td>
        <td>$phone</td>
        <td>$category</td>
        <td>
            <button class='btn btn-primary edit-btn' data-id='$id' data-name='$name' data-image='$image' data-email='$email' data-phone='$phone' data-category-id='$categoryId'>Редагувати</button>
        </td>
        <td>
            <button class='btn btn-danger delete-btn' data-id='$id'>Видалити</button>
        </td>
    </tr>
    ";
        }
        ?>

        </tbody>
    </table>
</div>

<?php
// Отримуємо категорії з бази даних
$categories = $dbh->query('SELECT id, name FROM categories')->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="post" action="/update_user.php"> <!-- Adjust path if necessary -->
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">ПІБ</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-image" class="form-label">Фото URL</label>
                        <input type="text" class="form-control" id="edit-image" name="image" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Пошта</label>
                        <input type="email" class="form-control" id="edit-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-phone" class="form-label">Телефон</label>
                        <input type="text" class="form-control" id="edit-phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-category" class="form-label">Категорія</label>
                        <select class="form-select" id="edit-category" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editButtons = document.querySelectorAll('.edit-btn');
        var deleteButtons = document.querySelectorAll('.delete-btn');
        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        var editForm = document.getElementById('editForm');

        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                var name = this.getAttribute('data-name');
                var image = this.getAttribute('data-image');
                var email = this.getAttribute('data-email');
                var phone = this.getAttribute('data-phone');
                var categoryId = this.getAttribute('data-category-id');

                document.getElementById('edit-id').value = id;
                document.getElementById('edit-name').value = name;
                document.getElementById('edit-image').value = image;
                document.getElementById('edit-email').value = email;
                document.getElementById('edit-phone').value = phone;
                document.getElementById('edit-category').value = categoryId;

                editModal.show();
            });
        });

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                if (confirm("Are you sure you want to delete this user?")) {
                    // Redirect to delete user script or handle deletion via AJAX
                    window.location.href = "/delete_user.php?id=" + id; // Adjust path if necessary
                }
            });
        });
    });
</script>
</body>
</html>
