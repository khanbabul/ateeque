<?php
$conn = new mysqli("localhost", "root", "", "MOBILE REPAIR.html");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $provider_id = $_POST['provider_id'];
  $name = $_POST['name'];
  $rating = $_POST['rating'];
  $comment = $_POST['comment'];

  $sql = "INSERT INTO reviews (provider_id, name, rating, comment)
          VALUES ('$provider_id', '$name', '$rating', '$comment')";
  $conn->query($sql);
}

$result = $conn->query("SELECT r.*, s.name AS provider_name
                        FROM reviews r
                        JOIN service_providers s ON r.provider_id = s.id
                        ORDER BY r.created_at DESC");

echo "<h2>All Service Reviews</h2>";
while($row = $result->fetch_assoc()) {
  echo "<div style='border:1px solid #ccc; margin:10px; padding:10px;'>
    <h3>Service: " . $row['provider_name'] . "</h3>
    <p><strong>" . $row['name'] . "</strong> rated " . $row['rating'] . "/5</p>
    <p>" . $row['comment'] . "</p>
    <small>Posted on " . $row['created_at'] . "</small>
  </div>";
}
?>

