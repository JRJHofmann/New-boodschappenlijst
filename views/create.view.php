<?php require 'partials/header.php'; ?>

<body>
    <?php require 'partials/nav.php'; ?>
    <br>

    <div>
        <form method="POST" action='/create'>
            <div> 
                <label for="name">Naam:</label>
                    <input type="text"  name="name"> <?htmlspecialchars($boodschap["number"]);?>
                    <br>
                    <?php if(isset($errors['name'])) : ?>
                        <p class ="error"> <?= $errors['name'] ?> </p>
                    <?php endif; ?>
                    <br>
            </div>
            <div> 
                <label for="number">Aantal:</label>
                <input type="number"  name="number"> <?htmlspecialchars($boodschap["number"]);?>
                <br>
                <?php if(isset($errors['number'])) : ?>
                    <p class ="error"> <?= $errors['number'] ?> </p>
                <?php endif; ?>
                <br>
            </div>
            <div>
                <label for="price">prijs:</label>
                <input type="number"  name="price" step="0.01"> <?htmlspecialchars($boodschap["price"]);?>
                <br>
                <?php if(isset($errors['price'])) : ?>
                    <p class ="error"> <?= $errors['price'] ?> </p>
                <?php endif; ?>
                <br>
            </div>
                <button type="submit">Toevoegen</button>
            </label>
        </form>
    </div>

<?php require 'partials/footer.php'; ?>