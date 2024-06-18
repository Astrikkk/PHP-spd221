<?php global $dbh; ?>
<?php
include $_SERVER["DOCUMENT_ROOT"]."/connection_database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $image = $_POST['image'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $category_id = $_POST['category_id'];

    $sql = "UPDATE users SET name = :name, image = :image, email = :email, phone = :phone, categories_id = :category_id WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':category_id', $category_id);

    if ($stmt->execute()) {
        header("Location: /index.php"); // Adjust path if necessary
    } else {
        echo "Error updating record.";
    }
} else {
    echo "Invalid request.";
}
?>