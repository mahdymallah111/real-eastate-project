<?php 
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$property_id = $_GET['id'];
$sql = "SELECT * FROM properties WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $property_id);
$stmt->execute();
$result = $stmt->get_result();
$property = $result->fetch_assoc();

if (!$property) {
    header("Location: index.php");
    exit();
}

 
$amenities = [];
if (!empty($property['amenities'])) {
    $amenities = explode(',', $property['amenities']);
}

 
if (isset($_SESSION['user_id']) && isset($_POST['book'])) {
   
    if (!isset($_POST['showing_date']) || empty($_POST['showing_date'])) {
        $error = "Please select a showing date!";
    } else {
        $user_id = $_SESSION['user_id'];
        $showing_date = $_POST['showing_date'];
        
        
        if (!strtotime($showing_date)) {
            $error = "Invalid date format!";
        } else {
            $check_sql = "SELECT * FROM bookings WHERE user_id = ? AND property_id = ?";
            $stmt = $conn->prepare($check_sql);
            $stmt->bind_param("ii", $user_id, $property_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 0) {
                $insert_sql = "INSERT INTO bookings (user_id, property_id, showing_date) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($insert_sql);
                $stmt->bind_param("iis", $user_id, $property_id, $showing_date);
                
                if ($stmt->execute()) {
                    $success = "Showing booked successfully for " . date('M j, Y g:i a', strtotime($showing_date));
                } else {
                    $error = "Error booking showing: " . $conn->error;
                }
            } else {
                $error = "You have already booked this property!";
            }
        }
    }
}
?>

<?php include 'header.php'; ?>

<main class="container">
    <div class="property-details">
        <div class="property-image-container">
            <img src="assets/images/<?php echo htmlspecialchars($property['image_path']); ?>" 
                 alt="<?php echo htmlspecialchars($property['title']); ?>"
                 class="property-main-image">
        </div>

        <div class="property-info">
            <h2><?php echo htmlspecialchars($property['title']); ?></h2>
            
            <div class="price-highlight">
                $<?php echo number_format($property['price']); ?>
                <small><?php echo $property['type'] === 'rent' ? '/month' : ''; ?></small>
            </div>
            
            <p><strong>Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>
            <p><strong>Type:</strong> <?php echo ucfirst(htmlspecialchars($property['type'])); ?></p>
            <p><strong>Bedrooms:</strong> <?php echo htmlspecialchars($property['bedrooms']); ?></p>
            <p><strong>Bathrooms:</strong> <?php echo htmlspecialchars($property['bathrooms']); ?></p>
            <p><strong>Area:</strong> <?php echo htmlspecialchars($property['area']); ?> sq ft</p>
            
            <?php if (!empty($amenities)): ?>
                <h4>Amenities</h4>
                <div class="amenities-list">
                    <?php foreach ($amenities as $amenity): ?>
                        <div class="amenity-item">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo htmlspecialchars(trim($amenity)); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <h4>Description</h4>
            <p><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
            
         </div>

    <div class="property-gallery">
            <h3>Exterior Views</h3>
            <div class="gallery-grid">
                <?php
                $ext_sql = "SELECT * FROM property_images WHERE property_id = ? AND image_type = 'exterior'";
                $stmt = $conn->prepare($ext_sql);
                $stmt->bind_param("i", $property_id);
                $stmt->execute();
                $ext_result = $stmt->get_result();
                
                while($ext_img = $ext_result->fetch_assoc()) {
                    echo '<div class="gallery-item">';
                    echo '<img src="assets/images/properties/exteriors/' . htmlspecialchars($ext_img['image_path']) . '" alt="Exterior view">';
                    echo '</div>';
                }
                
                if ($ext_result->num_rows === 0) {
                    echo '<p>No exterior images available</p>';
                }
                ?>
            </div>
            
            <h3>Interior Views</h3>
            <div class="gallery-grid">
                <?php
                $int_sql = "SELECT * FROM property_images WHERE property_id = ? AND image_type = 'interior'";
                $stmt = $conn->prepare($int_sql);
                $stmt->bind_param("i", $property_id);
                $stmt->execute();
                $int_result = $stmt->get_result();
                
                while($int_img = $int_result->fetch_assoc()) {
                    echo '<div class="gallery-item">';
                    echo '<img src="assets/images/properties/interiors/' . htmlspecialchars($int_img['image_path']) . '" alt="Interior view">';
                    echo '</div>';
                }
                
                if ($int_result->num_rows === 0) {
                    echo '<p>No interior images available</p>';
                }
                ?>
            </div>

            </div>
    
<div class="booking-section">
    <?php if (isset($_SESSION['user_id'])): ?>
        
        <?php if (!empty($property['maps_link'])): ?>
            <a href="<?php echo htmlspecialchars($property['maps_link']); ?>" 
               target="_blank" 
               class="btn maps-btn" 
               style="display: block; margin-bottom: 20px; background-color: #4285F4; color: white;">
                <i class="fas fa-map-marker-alt"></i> View on Google Maps
            </a>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="showing_date">Select Showing Date:</label>
                <input type="datetime-local" id="showing_date" name="showing_date" required 
                       min="<?php echo date('Y-m-d\TH:i'); ?>" 
                       value="<?php echo isset($_POST['showing_date']) ? htmlspecialchars($_POST['showing_date']) : ''; ?>">
            </div>
            <button type="submit" name="book" class="book-btn">Book a Showing</button>
        </form>
        
        <?php if (isset($success)): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php endif; ?>
    <?php else: ?>
        <a href="login.php" class="login-to-book">Login to Book This Property</a>
    <?php endif; ?>
</div>
      
        </div>
    
</main>

<?php include 'footer.php'; ?>