<?php 
try {
    $connect = new PDO("mysql:host=localhost;dbname=farhaevents", "root", "");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$search = "";  
$query = "SELECT edition.image, edition.dateEvent, edition.timeEvent, edition.NumSalle,
          evenement.eventTitle, evenement.eventType, evenement.eventId
          FROM edition
          JOIN evenement ON edition.eventId = evenement.eventId";

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query .= " WHERE evenement.eventTitle LIKE :search 
                OR evenement.eventType LIKE :search 
                OR edition.dateEvent LIKE :search";
}

$stmt = $connect->prepare($query);

if (isset($_POST['search'])) {
    $stmt->execute([':search' => "%$search%"]);
} else {
    $stmt->execute();
}

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements à Tanger</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #D3BBCB;
    }

    header {
        background-color: #A6AAA8;
        padding: 10px 0;
    }

    nav ul {
        list-style-type: none; 
        text-align: center; 
        margin: 0;
        padding: 0;
    }

    nav ul li {
        display: inline-block; 
        margin-right: 20px; 
    }

    nav ul li a {
        color: white; 
        font-size: 18px;
        padding: 10px 15px; 
        border-radius: 5px; 
        transition: background-color 0.3s ease;
    }

    nav ul li a:hover {
        background-color: #D3BBCB; 
        color: white; 
    }

    nav ul li a:active {
        background-color: #D3BBCB; 
    }

    .search-form {
        text-align: center;
        margin: 20px auto;
    }

    .search-input {
        padding: 10px;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .search-button {
        padding: 10px 15px;
        background-color: #A6AAA8;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .search-button:hover {
        background-color: #E7D8E2;
    }

    #events {
        padding: 40px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 30px;
    }

    .event {
        background-color:rgb(231, 216, 226);;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease-in-out;
    }

    .event:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }

    .event h3, .event p {
        text-align: center;
    }

    .event img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .event-link {
        color: #333;
    }

    .event-link:hover {
        color:rgb(78, 27, 208);
    }

    .event-link:hover .event {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }

    footer {
        text-align: center;
        padding: 10px;
    }
    
</style>

<body>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Connection</a></li>
            <li><a href="register.php">register</a></li>
            </ul>
    </nav>
</header>
    <form method="POST" class="search-form">
        <input type="text" name="search" placeholder="Search for an event..." value="<?= htmlspecialchars($search) ?>" class="search-input" required>
        <button type="submit" class="search-button">Search</button>
    </form>

    <section id="events">
    <?php if (empty($rows)): ?>
        <p style="text-align:center;">Aucun événement trouvé.</p>
    <?php else: ?>
        <?php foreach ($rows as $event): ?>
                <a href="detail.php?id=<?= htmlspecialchars($event['eventId']); ?>" class="event-link">
                <div class="event">
                    <img src="<?= htmlspecialchars($event['image']); ?>" alt="Image de l'événement" class="event-image">
                    <h3><?= htmlspecialchars($event['eventTitle']); ?></h3>
                    <p><strong>Type:</strong> <?= htmlspecialchars($event['eventType']); ?></p>
                    <p><strong>Date:</strong> <?= htmlspecialchars($event['dateEvent']); ?></p>
                    <p><strong>Time:</strong> <?= htmlspecialchars($event['timeEvent']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2025 Événements à Tanger</p>
    </footer>
</body>
</html>
