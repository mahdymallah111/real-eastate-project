<?php include 'config.php'; ?>

<?php include 'header.php'; ?>

<main class="container">
    <h2>All Properties</h2>
    
    <div class="property-grid">
        <?php

        $sql = "SELECT * FROM properties";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

                echo '<div class="property-card">';
                echo '<img src="assets/images/' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                echo '<h3>' . $row['title'] . '</h3>';
                echo '<p><strong>Location:</strong> ' . $row['location'] . '</p>';
                echo '<p class="priceid"><strong>Price:</strong> $' . number_format($row['price']) . '</p>';
                echo '<p><strong>Type:</strong> ' . ucfirst($row['type']) . '</p>';
                echo '<a href="view.php?id=' . $row['id'] . '" class="btn">View Details</a>';
                echo '</div>';
                
            }
        } else {
            echo '<p>No properties available at the moment.</p>';
        }
        ?>
    </div>
</main>

<?php include 'footer.php'; ?>