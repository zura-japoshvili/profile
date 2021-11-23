<?php 
    include_once "include/header.php";

    $pdo = new PDO('mysql:host=localhost;dbname=profile_db;','root','' );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $statement = $pdo->prepare('INSERT INTO profile (name,surname, position,image,sex,email,age) 
        VALUES (:name,:surname,:position,:image,:sex,:email,:age)');
        

        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $position = $_POST['position'];
        $image = $_FILES['image'] ?? null;
        $imagePath = '';

        if(isset($_POST['sex'])){
            $sex = $_POST['sex'];
        }
        $email = $_POST['email'];
        $age = $_POST['age'];

        if($image){
            $imagePath = 'images/' . randomString(8) . '/' . $image['name']; 
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        if(!$name or !$surname or !$position or !$image or !$sex or !$email or !$age ){
            $errors[] = "გთხოვთ შეავსოთ თითოეული ველი";
        }

        if(empty($errors)){
            $statement->bindValue(':name', $name);
            $statement->bindValue(':surname', $surname);
            $statement->bindValue(':position', $position);
            $statement->bindValue(':image', $imagePath);
            $statement->bindValue(':sex', $sex);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':age', $age);
        
            $statement->execute();
            
            header('Location: profile.php');
        }
    }

    function randomString($n){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for($i = 0;$i < $n;$i++){
            $index = rand(0,strlen($characters) -1);
            $str .= $characters[$index];
        }
        return $str;
    }
?>



    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Home</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</button>
    </li>
    </ul>

    <form method="post" enctype="multipart/form-data">
        <?php 
            if(!empty($errors)):
        ?>
            <div class="alert alert-danger" role="alert">
                <?php 
                    foreach($errors as $i){
                        echo $i . "<br>";
                    }
                ?>
            </div>
        <?php     
        endif
        ?>

        <div class="mb-3">
            <label class="form-label">Email address*</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1">
        </div>
        <div class="mb-3">
            <label class="form-label">Name*</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Surname*</label>
            <input type="text" name="surname" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Position*</label>
            <input type="text" name="position" class="form-control" id="exampleInputEmail1">
        </div>
        <div class="mb-3">
            <label class="form-label">Age*</label>
            <input type="number" name="age" class="form-control">
        </div>
        <div class="mb-3">
            <label>Profile Image*</label><br>
            <input type="file" name="image">
        </div>
        <h4 class="sam">Choose a gender</h4>
        <div class="form-check">
            <input class="form-check-input" name="sex" type="radio" value="Female" checked>
            <label class="form-check-label">
                Female
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" name="sex" type="radio" value="Male">
            <label class="form-check-label">
                Male
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<?php 
    include_once "include/footer.php";
?>