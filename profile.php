<?php 
    include_once "include/header.php";

    $pdo = new PDO('mysql:host=localhost;dbname=profile_db;','root','');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = $pdo->prepare("SELECT * FROM profile");
    $statement->execute();

    $profiles = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<a href="index.php">დაბრუნება</a>
<h1>ALL PROFILES</h1>
<?php echo 'პროფილების რაოდენობა: ' . count($profiles); ?>
<div class='profile-cont'>
<?php foreach($profiles as $i => $profile): ?>
    <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="<?php echo $profile['image'] ?>" alt="Card image cap">
        <div class="card-body">
            <h5 class="card-title">სრული სახელი: <?php echo $profile['name'] .' ' . $profile['surname'] ?></h5>
            <p class="card-text">პოზიცია: <?php echo $profile['position'] ?></p>
            <p>ასაკი: <?php echo $profile['age'] . ' წლის' ?></p>
            <p>სქესი: <?php echo $profile['sex'] ?></p>
        </div>
    </div>
<?php endforeach ?>
</div>

<?php 
    include_once "include/footer.php";
?>