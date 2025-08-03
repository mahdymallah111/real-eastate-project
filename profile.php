

<?php 
include 'config.php';

 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

 
if (isset($_GET['cancel_booking'])) {
    $booking_id = $_GET['cancel_booking'];
    
    
    $check_sql = "SELECT * FROM bookings WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $booking_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $delete_sql = "DELETE FROM bookings WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $booking_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Booking cancelled successfully!";
            header("Location: profile.php");
            exit();
        } else {
            $error = "Error cancelling booking: " . $conn->error;
        }
    } else {
        $error = "Invalid booking or you don't have permission to cancel this booking!";
    }
}

 
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


 
if (isset($_POST['delete_profile'])) {
    $user_id = $_SESSION['user_id'];
    
    
    $delete_bookings_sql = "DELETE FROM bookings WHERE user_id = ?";
    $stmt = $conn->prepare($delete_bookings_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
   
    $delete_user_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_user_sql);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
       
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    } else {
        $error = "Error deleting profile: " . $conn->error;
    }
}
?>


<?php include 'header.php'; ?>

<main class="container">
    <h2>User Profile</h2>
    
    <?php if (isset($_SESSION['success'])): ?>

        <div class="alert success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>

    <?php endif; ?>
    
    <?php if (isset($error)): ?>

        <div class="alert error"><?php echo $error; ?></div>

    <?php endif; ?>
    
    <div class="profile-info">
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
    </div>

    
    <div class="profile-actions">
    <form method="POST" onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone!');">
        <button type="submit" name="delete_profile" class="btn btn-danger">Delete My Profile</button>
    </form>
</div>
    
    <h3>Your Bookings</h3>
    <div class="bookings-list">
        <?php
       $sql = "SELECT p.*, b.id as booking_id, b.showing_date FROM properties p 
        JOIN bookings b ON p.id = b.property_id 
        WHERE b.user_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
    echo '<div class="booking-card" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1); padding: 15px; margin-bottom: 20px; border-radius: 5px;">';
    echo '<h4>' . htmlspecialchars($row['title']) . '</h4>';
    echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
    echo '<p><strong>Price:</strong> $' . number_format($row['price']) . '</p>';
    echo '<p><strong>Showing Date:</strong> ' . date('F j, Y \a\t g:i A', strtotime($row['showing_date'])) . '</p>';
    echo '<a href="view.php?id=' . $row['id'] . '" class="btn" style="margin-right: 10px;">View Property</a>';
    echo '<a href="profile.php?cancel_booking=' . $row['booking_id'] . '" class="btn" style="background-color: #ff4444; color: white;" onclick="return confirm(\'Are you sure you want to cancel this booking?\')">Cancel Booking</a>';
    echo '</div>';
}
        } else {
            echo '<div class="no-bookings">';
            echo '<p>You have no bookings yet.</p>';
            echo '<a href="indexx.php" class="browse-btn">Browse Properties to Book a Showing</a>';
            echo '</div>';
        }
        ?>
    </div>
    
</main>

<?php include 'footer.php'; ?>