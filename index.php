<?php include 'header.php'; ?>
<?php include 'config.php'; ?>
<main class="container">
    <section class="hero">
        <h2>Find Your Dream Home</h2>
        <p>Browse our selection of premium properties</p>
        <a href="indexx.php" class="btn">View Properties</a>
    </section>

    <section class="featured-properties">
        <h3>Featured Properties</h3>
        <div class="property-grid">
            <?php
            
            $sql = "SELECT * FROM properties ORDER BY RAND() LIMIT 3";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="property-card">';
                    echo '<img src="assets/images/' . $row['image_path'] . '" alt="' . $row['title'] . '">';
                    echo '<h4>' . $row['title'] . '</h4>';
                    echo '<p>' . $row['location'] . '</p>';
                    echo '<p>$' . number_format($row['price']) . '</p>';
                    echo '<a href="view.php?id=' . $row['id'] . '" class="btn">View Details</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No properties available at the moment.</p>';
            }
            ?>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>

